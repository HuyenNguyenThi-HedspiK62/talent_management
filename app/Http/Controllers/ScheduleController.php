<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    public function index(Request $request){
        if($request->get('search') != null){
            $schedules = Schedule::where('schedule_name', 'like', '%'. $request->get('search') .'%')->with('users')->get();
        }else {
            $schedules = Schedule::all()->load('users');
        }
        return view('schedule.index', ['schedules' => $schedules]);
    }

    public function show($scheduleId, $userId){
        $schedule   = Schedule::where('id', $scheduleId)->with('users', function($query) use ($userId){
            return $query->where('users.id', $userId);
        })->first();
        return view('schedule.show', ['schedule' => $schedule]);
    }

    public function delete($scheduleId){
        dd($scheduleId);
    }

    public function store(Request $request){
        $schedule = new Schedule();
        $schedule->schedule_name = $request->schedulename;
        $schedule->date = $request->date;
        $schedule->location = $request->location;
        $schedule->information = $request->info;
        $schedule->save();
        $persons = DB::table('users')->get();
        // $task = $request->person;
        // dd($task);
        //$task = new Task();
        return view('schedule.add', compact('persons'));
    }

    public function addSchedule(Request $request){
        $persons = DB::table('users')->get();
        return view('schedule.add', compact('persons'));
    }

    public function editSchedule($id){
        return view('schedule.edit')->with('schedule', Schedule::find($id));
    }

    public function update(Request $request, $id)
    {
        //
        $data = request()->all();
        $talent = User::find($id);
        $talent->name = $data['tname'];
        $talent->email = $data['email'];
        $talent->gender = $request->has('gender');;
        $talent->role = $request->has('role');;
        $talent->join_company_date = $data['date'];
        $talent->information = $data['description'];
        $talent->save();
        return view('schedule.edit')->with('schedule', Schedule::find($id));
    }
}
