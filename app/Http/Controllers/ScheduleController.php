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
            $schedules = Schedule::where('schedule_name', 'like', '%'. $request->get('search') .'%')->with('users')->simplePaginate(10);
        }else {
            $schedules = Schedule::with('users')->simplePaginate(10);
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
        $schedule = Schedule::findOrFail($scheduleId);
        $schedule->users()->sync([]);
        $schedule->delete();
        return redirect()->route('schedule.index', ['option' => 'all']);
    }

    public function store(Request $request){
        $schedule = new Schedule();
        $schedule->schedule_name = $request->schedulename;
        $schedule->date = $request->date;
        $schedule->location = $request->location;
        $schedule->information = $request->info;
        $schedule->save();
        $schedule->users()->attach($request->get('person'));

        if($request->get('search') != null){
            $schedules = Schedule::where('schedule_name', 'like', '%'. $request->get('search') .'%')->with('users')->get();
        }else {
            $schedules = Schedule::all()->load('users');
        }
        $persons = DB::table('users')->get();
        return view('schedule.index', compact('persons','schedules'));
    }

    public function addSchedule(Request $request){
        $persons = DB::table('users')->where('role', 1)->get();
        return view('schedule.add', compact('persons'));
    }

    public function editSchedule($id){
        $s = DB::table('tasks')->select('status')->where('schedule_id', $id)->get();
        $persons = DB::table('users')->where('role', 1)->get();
        return view('schedule.edit', compact('persons', 's'))->with('schedule', Schedule::find($id));
    }

    public function update(Request $request, $id)
    {
        //
        //dd($request);
        $schedule = Schedule::find($id);
        $schedule->schedule_name = $request->schedulename;
        $schedule->date = $request->date;
        $schedule->location = $request->location;
        $schedule->information = $request->info;
        $schedule->save();
        $schedule->users()->sync($request->get('person'));
        $talentId = $request->get('person');
        //dd($request->get('person'));
        return redirect()->route('schedule.show', ['scheduleId' => $id, 'userId'=>$talentId]);
    }
}
