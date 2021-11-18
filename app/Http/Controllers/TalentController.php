<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class TalentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $talents = User::orderBy('created_at','desc')->paginate(10);
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
        $talent = new User;
        $talent->name = $request->tname;
        $talent->email = $request->email;
        $talent->password = $request->password;
        $talent->gender = $request->input('gender');
        $talent->role = $request->input('role');
        $talent->join_company_date = $request->date;
        $talent->information = $request->description;
        $talent->save();
        return view('talent.add');
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
        return view('talent.profile', ['talent' => $talent, 'infos' => $infos]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }
    
    public function editTalent(){
        return view('talent.edit');
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
        //
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
