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
                'tname' => 'required|string',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8',
                'gender' => 'required',
                'date' => 'required|date'
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
        return view('talent.show')->with('talents', $talents);
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
                'tname' => 'string',
                'email' => 'email',
                'date' => 'date'
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
                return view('talent.profile', ['talent' => $talent, 'infos' => $infos, 'results' => $results]);
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
