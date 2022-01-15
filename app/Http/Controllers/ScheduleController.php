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

    public function index(Request $request, $option){
        if($request->get('search') != null){
            $schedules = Schedule::where(function($query) use ($request){
                $query->where('schedule_name', 'ilike', '%'. $request->get('search') .'%')
                ->orWhere('date', 'ilike', '%'. $request->get('search') .'%')
                ->orWhere('location', 'ilike', '%'. $request->get('search') .'%')
                ->orWhere('information', 'ilike', '%'. $request->get('search') .'%');
            })
            ->with('users')
            ->orderBy('created_at','desc')
            ->paginate(5);
        }else {
            if($option == 'all'){
                $schedules = Schedule::with('users')->orderBy('created_at','desc')->paginate(5);
                return view('schedule.index', ['schedules' => $schedules]);
            }
            $option = $this->FILTER_OPTION[$option];
            $schedules = Schedule::where('status', $option)
            ->with('users')
            ->orderBy('created_at','desc')
            ->paginate(5);
        }
        return view('schedule.index', ['schedules' => $schedules]);
    }

    public function show($scheduleId){
        $schedule   = Schedule::find($scheduleId);
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
                'schedule_name' => 'required|string|max:255',
                'location'      => 'required|string|max:255',
                'talents'       => 'required',
                'date'          => 'required|date|after:yesterday',
                'information'   => 'nullable|string|max:10000',
                'start_time'    => 'required',
                'end_time'      => 'required|after:start_time',
                'reviewer'      => 'required'
            ],
            [
                'schedule_name.required' => 'スケジュール名が入力されていません。',
                'schedule_name.max'      => 'スケジュール名の長さは255文字を超えることはできません。',
                'location.required'      => '場所が入力されていません。',
                'location.max'           => '場所のの長さは255文字を超えることはできません。',
                'talents.required'       => '担当者が入力されていません。',
                'date.required'          => '開始日が入力されていません。',
                'date.date'              => '開始日の形式が正しくありません。',
                'date.after'             => '本日以降または本日の日付を選択してください。',
                'information.max'        => '詳細の情報の長さは10000文字を超えることはできません。',
                'start_time.required'    => '開始時間が入力されていません。',
                'end_time.required'      => '終了時間が入力されていません。',
                'end_time.after'         => '終了時間は開始日より後の日付である必要があります。',
                'reviewer.required'      => 'レビュアーが入力されていません。'
            ]);
        if ($validate->fails()) {
            return redirect()->back()->withInput()->withErrors($validate);
        }
        $data = $request->only(['schedule_name', 'location', 'date', 'information', 'reviewer', 'start_time', 'end_time']);
        $schedule = Schedule::create($data);
        $schedule->users()->attach($request->get('talents'));
        return redirect()->route('schedule.index', ['option' => 'all']);
    }

    public function addSchedule(Request $request){
        $reviewers = User::where('role', 0)->get();
        $talents = User::where('role', 1)->get();
        return view('schedule.add', compact('talents', 'reviewers'));
    }

    public function editSchedule($id){
        $talents = User::where('role', 1)->get();
        $reviewers = User::where('role', 0)->get();
        $schedule = Schedule::find($id);
        $selectedTalents = [];
        foreach ($schedule->users as $user){
            array_push($selectedTalents, $user->id);
        }
        return view('schedule.edit', [
            'schedule' => Schedule::find($id),
            'talents' => $talents,
            'reviewers' => $reviewers,
            'selectedTalents' => $selectedTalents
        ]);
    }

    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(),
            [
                'schedule_name' => 'required|string|max:255',
                'location'      => 'required|string|max:255',
                'date'          => 'required|after:yesterday',
                'information'   => 'nullable|string|max:10000',
                'start_time'    => 'required',
                'end_time'      => 'required|after:start_time',
                'reviewer'      => 'required'
            ],
            [
                'schedule_name.required' => 'スケジュール名が入力されていません。',
                'schedule_name.max'      => 'スケジュール名の長さは255文字を超えることはできません。',
                'location.required'      => '場所が入力されていません。',
                'location.max'           => '場所のの長さは255文字を超えることはできません。',
                'date.required'          => '開始日が入力されていません。',
                'date.after'             => '本日以降または本日の日付を選択してください。',
                'information.max'        => '詳細の情報の長さは10000文字を超えることはできません。',
                'reviewer.required'      => 'レビュアーが入力されていません。'
            ]);
            if ($validate->fails()) {
                return redirect()->back()->withInput()->withErrors($validate);
            }
        $data = $request->only(['schedule_name', 'location', 'date', 'information', 'review', 'start_time', 'end_time']);
        $schedule = Schedule::find($id);
        $schedule->update($data);
        $attachedTalents = [];
        foreach ($schedule->users as $user){
            array_push($attachedTalents, $user->id);
        }
        foreach ($request->get('talents') as $talent){
            if(!in_array($talent, $attachedTalents)){
                $schedule->users()->attach(User::find($talent));
            }
        }
        foreach ($attachedTalents as $talent){
            if(!in_array($talent, $request->get('talents'))){
                $schedule->users()->detach(User::find($talent));
            }
        }
        return redirect()->route('schedule.index', ['option' => 'all']);
    }

    public function updateStatus(Request $request){
        $schedule = Schedule::find($request->get('schedule_id'));
        $schedule->status = $request->get('status');
        $result =$schedule->save();
        if($result) {
            return response($request->get('schedule_id'), 200);
        }
        return response('error', 500);
    }
}
