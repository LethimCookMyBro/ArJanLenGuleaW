<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class TeamsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teams = DB::table('Teams')->get();
        return view('teams.index',compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       $countries = DB::table('Countries')->get();
       return view('teams.create',compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'team_id' => 'required',
            'country_id' => 'required',
            'coach_name' => 'required',
            'group_name' => 'required',
        ]);
        try{
        DB::table('Teams')->insert([
             'team_id' => $request->team_id,
             'country_id' => $request->country_id,
             'coach_name' =>  $request->coach_name,
             'group_name' =>  $request->group_name,
        ]);

        return redirect()->route('teams.index')->with('success','Teams create successfully.');
        }catch(\Exception $e){
            return redirect()->route('teams.index')->with('failed','Failed to create teams.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {    
        $teams = DB::table('Teams')->where('team_id',$id)->get();
        $countries = DB::table('Countries')->get();
        return view('teams.edit',compact('countries', 'teams'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'country_id' => 'required',
            'coach_name' => 'required',
            'group_name' => 'required',
        ]);
        try{
        DB::table('Teams')->where('team_id',$id)->update([
             'country_id' =>  $request->country_id,
             'coach_name' =>  $request->coach_name,
             'group_name' =>  $request->group_name,
        ]);

        return redirect()->route('teams.index')->with('success','Teams create successfully.');
    }    catch(\Exception $e){
            return redirect()->route('teams.index')->with('failed','Failed to update teams.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
        DB::table('Teams')->where('team_id',$id)->delete();
        return redirect()->route('teams.index')->with('success','Teams delete successfully.');
    }   catch(\Exception $e){
        return redirect()->route('teams.index')->with('failed','Failed to delete teams.');
    }
}
}
