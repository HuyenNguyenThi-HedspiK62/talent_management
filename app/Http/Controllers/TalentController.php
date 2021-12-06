<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Schedule;
use App\Models\Task;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class TalentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->get('search') != null) {
            $talents = User::where('role', 1)->orderBy('created_at','desc')
            ->where(function($query) use ($request){
                $query->where('name', 'like', '%'. $request->get('search') .'%')
                      ->orWhere('email', 'LIKE', '%'. $request->get('search') .'%');
            })
            ->paginate(10);
        }
        else {
            $talents = User::where('role', 1)->orderBy('created_at','desc')->paginate(10);
        }
        return view('talent.show')->with('talents', $talents);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validate = Validator::make($request->all(),
            [
                'tname' => 'required|string|max:50',
                'email' => 'required|email:rfc,dns|regex:/^\S*$/u|unique:users|max:255',
                'password' => 'required|between:8,20',
                'gender' => 'required',
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
                'gender.required'   => '性別が入力されていません。',
                'date.required'     => '会社入日が入力されていません。',
                'date.date'         => '会社入日の形式が正しくありません。',
                'date.before'       => '本日以前または本日の日付を選択してください。',
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
                $talent->role = '1';
                $talent->join_company_date = $request->date;
                $talent->information = $request->description;
                $talent->save();
                return redirect()->route('talent.index');
            }
    }

    public function addTalent(){
        return view('talent.add');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $talent) //$id
    {
        $infos = explode(". ", $talent->information);
        $results = $talent->schedule;
        return view('talent.profile', ['talent' => $talent, 'infos' => $infos, 'results' => $results]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function delete($talentId){
        $talent = User::findOrFail($talentId);
        $talent->delete();
        $talents = User::orderBy('created_at','desc')->simplePaginate(10);
        return redirect()->route('talent.index');
    }


    public function editTalent($id){
        return view('talent.edit')->with('talent', User::find($id));

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
                return redirect()->route('talent.show', ['talent' => $talent->id, 'option' => 'all']);
            }
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
