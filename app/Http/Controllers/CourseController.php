<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCourseRequest;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
class CourseController extends Controller
{
    private $FILTER_OPTION;

    public function __construct()
    {
        $this->FILTER_OPTION = [
            'all'         => 4,
            'not-started' => 0,
            'processing'  => 1,
            'done'        => 2,
            'interrupted' => 3
        ];
    }

    public function index(Request $request, $option)
    {
        if($request->get('search') != null){
            $courses = Course::where(function($query) use ($request){
                $query->where('name', 'like', '%'. $request->get('search') .'%')
                    ->orWhere('start_date', 'like', '%'. $request->get('search') .'%')
                    ->orWhere('end_date', 'like', '%'. $request->get('search') .'%')
                    ->orWhere('instructor', 'like', '%'. $request->get('search') .'%');
                })
                ->orderBy('created_at','desc')
                ->paginate(10);
        }else {
            if($option == 'all'){
                $courses = Course::orderBy('created_at','desc')->paginate(10);
                return view('course.index', ['courses' => $courses]);
            }
            $option = $this->FILTER_OPTION[$option];
            $courses = Course::where('status', $option)
                ->orderBy('created_at','desc')
                ->paginate(10);
        }
        return view('course.index', ['courses' => $courses]);
    }

    public function create()
    {
        $instructors = User::where('role', 0)->get();
        $talents = User::where('role', 1)->get();
        return view('course.add', ['instructors' => $instructors, 'talents' => $talents]);
    }

    public function store(StoreCourseRequest $request)
    {
        $data = $request->only('name', 'detail', 'location', 'start_date', 'end_date', 'start_time',
                    'end_time', 'max_score', 'instructor');
        $course = Course::create($data);
        $course->users()->attach($request->get('talents'));
        return redirect()->route('course.index', ['option' => 'all']);
    }

    public function show($id)
    {
        $course = Course::where('id', $id)->with(['users' => function($q){
            $q->select('name');
        }])->first();
        return view('course.show', ['course' => $course]);
    }

    public function edit($id)
    {
        $instructors = User::where('role', 0)->get();
        $talents = User::where('role', 1)->get();
        $course = Course::where('id', $id)->with('users')->first();
        return view('course.edit', [
            'instructors' => $instructors,
            'talents' => $talents,
            'course' => $course
        ]);
    }

    public function update(StoreCourseRequest $request, $id)
    {
        $data = $request->only('name', 'detail', 'location', 'start_date', 'end_date', 'start_time',
            'end_time', 'max_score', 'instructor');
        $course = Course::find($id);
        $course->update($data);
        $course->users()->sync($request->get('talents'));
        return redirect()->route('course.index', ['option' => 'all']);
    }

    public function updateStatus(Request $request)
    {
        $result = Course::where('id', $request->get('id'))->update(['status' => $request->get('status')]);
        if($result) {
            return response($request->get('id'), 200);
        }
        return response('error', 500);
    }

    public function updateScore(Request $request, $id)
    {
        $course = Course::find($id);
        for ($i = 0; $i < count($course->users); $i++){
            $course->users[$i]->pivot->score = $request->get('scores')[$i];
            $course->users[$i]->pivot->comment = $request->get('comments')[$i];
            $course->users[$i]->pivot->save();
        }
        return redirect()->route('course.show', ['id' => $id]);
    }

    public function delete($id)
    {
        $course = Course::find($id);
        $course->users()->sync([]);
        $course->delete();
        return redirect()->route('course.index', ['option' => 'all']);
    }
}
