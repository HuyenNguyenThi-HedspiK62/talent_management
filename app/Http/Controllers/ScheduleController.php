<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class ScheduleController extends Controller
{
    public function index(Request $request){
        if($request->get('search') != null){
            $schedules = Schedule::where('schedule_name', 'like', '%'. $request->get('search') .'%')->with('users')->orderBy('created_at','desc')->paginate(10);
        }else {
            $schedules = Schedule::with('users')->orderBy('created_at','desc')->paginate(10);
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
        $validate = Validator::make($request->all(),
            [
                'schedulename' => 'required|string|max:255',
                'location' => 'required|string|max:255',
                'person' => 'required',
                'date' => 'required|date|after:yesterday',
                'info' => 'nullable|string|max:10000'
            ],
            [
                'schedulename.required' => 'スケジュール名が入力されていません。',
                'schedulename.max'      => 'スケジュール名の長さは255文字を超えることはできません。',
                'location.required'     => '場所が入力されていません。',
                'location.max'          => '場所のの長さは255文字を超えることはできません。',
                'person.required'       => '担当者が入力されていません。',
                'date.required'         => '開始日が入力されていません。',
                'date.date'             => '開始日の形式が正しくありません。',
                'date.after'            => '本日以降または本日の日付を選択してください。',
                'info.max'              => '詳細の情報の長さは10000文字を超えることはできません。'
            ]);
            if ($validate->fails()) {
                return redirect()->back()->withInput()->withErrors($validate);
            }
        $schedule = new Schedule();
        $schedule->schedule_name = $request->schedulename;
        $schedule->date = $request->date;
        $schedule->location = $request->location;
        $schedule->information = $request->info;
        $schedule->save();
        $schedule->users()->attach($request->get('person'));
        return redirect()->route('schedule.index', ['option' => 'all']);
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
        $validate = Validator::make($request->all(),
            [
                'schedulename' => 'required|string|max:255',
                'location' => 'required|string|max:255',
                'date' => 'required|after:yesterday',
                'info' => 'nullable|string|max:10000'
            ],
            [
                'schedulename.required' => 'スケジュール名が入力されていません。',
                'schedulename.max'      => 'スケジュール名の長さは255文字を超えることはできません。',
                'location.required'     => '場所が入力されていません。',
                'location.max'          => '場所のの長さは255文字を超えることはできません。',
                'date.required'         => '開始日が入力されていません。',
                'date.after'            => '本日以降または本日の日付を選択してください。',
                'info.max'              => '詳細の情報の長さは10000文字を超えることはできません。'
            ]);
            if ($validate->fails()) {
                return redirect()->back()->withInput()->withErrors($validate);
            }
        $schedule = Schedule::find($id);
        $schedule->schedule_name = $request->schedulename;
        $schedule->date = $request->date;
        $schedule->location = $request->location;
        $schedule->information = $request->info;
        $schedule->save();
        DB::table('tasks')->where('schedule_id', $id)->update(['tasks.status' => $request->status]);
        $schedule->users()->sync($request->get('person'));
        $talentId = $request->get('person');
        return redirect()->route('schedule.show', ['scheduleId' => $id, 'userId'=>$talentId]);
    }
}
