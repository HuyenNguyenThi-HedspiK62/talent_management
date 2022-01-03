<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCourseRequest;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::all();
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
        return redirect()->route('course.index');
    }


    public function show()
    {
        return view('course.show');
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
        return redirect()->route('course.index');
    }

    public function destroy($id)
    {

    }
}
