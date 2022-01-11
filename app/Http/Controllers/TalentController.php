<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Schedule;
use App\Models\Task;
use App\Models\Course;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class TalentController extends Controller
{
    public function index(Request $request)
    {
        if($request->get('search') != null) {
            $talents = User::where('role', 1)->orderBy('created_at','desc')
            ->where(function($query) use ($request){
                $query->where('name', 'ilike', '%'. $request->get('search') .'%')
                      ->orWhere('email', 'ilike', '%'. $request->get('search') .'%');
            })
            ->paginate(10);
        }
        else {
            $talents = User::where('role', 1)->orderBy('created_at','desc')->paginate(10);
        }
        return view('talent.show')->with('talents', $talents);
    }

    public function indexManager(Request $request)
    {
        if($request->get('search') != null) {
            $managers = User::where('role', 0)->orderBy('created_at','desc')
                ->where(function($query) use ($request){
                    $query->where('name', 'ilike', '%'. $request->get('search') .'%')
                        ->orWhere('email', 'ilike', '%'. $request->get('search') .'%');
                })
                ->paginate(10);
        }
        else {
            $managers = User::where('role', 0)->orderBy('created_at','desc')->paginate(10);
        }
        return view('manager.index')->with('managers', $managers);
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),
            [
                'tname' => 'required|string|max:50',
                'email' => 'required|email:rfc,dns|regex:/^\S*$/u|unique:users|max:255',
                'password' => 'required|between:8,20',
                'gender' => 'required',
                'role' => 'required',
                'date' => 'required|date',
                'description' => 'nullable|string|max:10000'
            ],
            [
                'tname.required'    => '名前が入力されていません。',
                'tname.max'         => '名前の長さは50文字を超えることはできません。',
                'email.required'    => 'メールアドレスが入力されていません。',
                'email.email'       => 'メールの形式が正しくありません。',
                'email.regex'       => 'メールの形式が正しくありません。',
                'email.unique'      => 'すでに登録されているメールアドレスです。',
                'email.max'         => 'メールの長さは255文字を超えることはできません。',
                'gender.required'   => '性別が入力されていません。',
                'role.required'     => 'ロールが入力されていません。',
                'date.required'     => '会社入日が入力されていません。',
                'date.date'         => '会社入日の形式が正しくありません。',
                'password.required' => 'パスワードが入力されていません。',
                'password.between'  => 'パスワードは、8文字から20文字にしてください。',
                'description.max'   => '詳細の情報の長さは10000文字を超えることはできません。'
            ]);
            if ($validate->fails()) {
                return redirect()->back()->withInput()->withErrors($validate);
            } else {
                $talent = new User;
                $talent->name = $request->tname;
                $talent->email = $request->email;
                $talent->password = bcrypt($request->password);
                $talent->gender = $request->input('gender');
                $talent->role = $request->input('role');
                $talent->join_company_date = $request->date;
                $talent->information = $request->description;
                $talent->save();
                if($request->input('role') == 0){
                    return redirect()->route('manager.index');
                }
                return redirect()->route('talent.index');
            }
    }

    public function addTalent(){
        return view('talent.add');
    }

    public function show(User $talent) //$id
    {
        $infos = explode(". ", $talent->information);
        $results = $talent->schedule;
        $results = $results->sortBy(function($result){
            return $result->pivot->status;
        });
        $kosus = $talent->courses;
        $id = $talent->id;
        return view('talent.profile', ['talent' => $talent, 'infos' => $infos, 'results' => $results, 'kosus' => $kosus, 'id' => $id]);
    }

    public function delete($talentId){
        $talent = User::findOrFail($talentId);
        $talent->delete();
        $talents = User::orderBy('created_at','desc')->simplePaginate(10);
        return redirect()->route('talent.index');
    }


    public function editTalent($id){
        return view('talent.edit')->with('talent', User::find($id));

    }

    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(),
            [
                'tname' => 'required|string|max:50',
                'email' => 'required|email:rfc,dns|regex:/^\S*$/u|unique:users,email,'.$id.'|max:255',
                'date' => 'required|date|before:tomorrow',
                'description' => 'nullable|string|max:10000'
            ],
            [
                'tname.required'    => '名前が入力されていません。',
                'tname.max'         => '名前の長さは50文字を超えることはできません。',
                'email.required'    => 'メールアドレスが入力されていません。',
                'email.email'       => 'メールの形式が正しくありません。',
                'email.regex'       => 'メールの形式が正しくありません。',
                'email.unique'      => 'すでに登録されているメールアドレスです。',
                'email.max'         => 'メールの長さは255文字を超えることはできません。',
                'date.required'     => '会社入日が入力されていません。',
                'date.date'         => '会社入日の形式が正しくありません。',
                'date.before'       => '本日以前または本日の日付を選択してください。',
                'description.max'   => '詳細の情報の長さは10000文字を超えることはできません。'
            ]);
            if ($validate->fails()) {
                return redirect()->back()->withInput()->withErrors($validate);
            } else {
                $data = request()->all();
                $talent = User::find($id);
                $talent->name = $data['tname'];
                $talent->email = $data['email'];
                $talent->gender = $request->gender;
                $talent->join_company_date = $data['date'];
                $talent->information = $data['description'];
                $talent->save();
                $infos = explode(". ", $talent->information);
                $results = $talent->schedule;
                return redirect()->route('talent.show', ['talent' => $talent->id, 'option' => 'all', 'choose' => 'sukejyu']);
            }
    }

    public function destroy($id)
    {

    }
}
