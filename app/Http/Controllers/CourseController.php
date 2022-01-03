<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCourseRequest;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::all();
        return view('course.index', ['courses' => $courses]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $instructors = User::where('role', 0)->get();
        $talents = User::where('role', 1)->get();
        return view('course.add', ['instructors' => $instructors, 'talents' => $talents]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCourseRequest $request)
    {
        $data = $request->only('name', 'detail', 'location', 'start_date', 'end_date', 'start_time',
                    'end_time', 'max_score', 'instructor');
        $course = Course::create($data);
        $course->users()->attach($request->get('talents'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('course.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->only('name', 'detail', 'location', 'start_date', 'end_date', 'start_time',
            'end_time', 'max_score', 'instructor');
        Course::where('id', $id)->update($data);
        $course = Course::where('id', $id)->first();
        $course->users()->sync($request->get('talents'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
