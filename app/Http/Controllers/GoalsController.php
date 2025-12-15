<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class GoalsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $goals = DB::table('Goals')->get();
        return view('goals.index',compact('goals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $matches = DB::table('Matches')->get();
        $players = DB::table('Players')->get();
        return view('goals.create', compact('matches', 'players'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'goal_id' => 'required',
            'match_id' => 'required',
            'player_id' => 'required',
            'goal_time' => 'required',
            'is_penalty' => 'required',
        ]);
        try{
        DB::table('Goals')->insert([
            'goal_id' => $request->goal_id,
            'match_id' => $request->match_id,
            'player_id' =>  $request->player_id,
            'goal_time' =>  $request->goal_time,
            'is_penalty' =>  $request->is_penalty,
        ]);

        return redirect()->route('goals.index')->with('success','Goals create successfully.');
    } catch (\Exception $e) {
        return redirect()->route('goals.index')->with('failed','Failed to create goals.');
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
        $goals = DB::table('Goals')->where('goal_id',$id)->get();
        $matches = DB::table('Matches')->get();
        $players = DB::table('Players')->get();
        return view('goals.edit', compact('goals', 'matches', 'players'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'match_id' => 'required',
            'player_id' => 'required',
            'goal_time' => 'required',
            'is_penalty' => 'required',
        ]);
        try{
        DB::table('Goals')->where('goal_id',$id)->update([
            'match_id' => $request->match_id,
            'player_id' =>  $request->player_id,
            'goal_time' =>  $request->goal_time,
            'is_penalty' =>  $request->is_penalty,
        ]);

        return redirect()->route('goals.index')->with('success','Goals update successfully.');
    } catch (\Exception $e) {
        return redirect()->route('goals.index')->with('failedr','An failed occurred while updating.');
    }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
        DB::table('Goals')->where('goal_id',$id)->delete();
        return redirect()->route('goals.index')->with('success','Goals delete successfully.');
        }catch(\Exception $e){
            return redirect()->route('goals.index')->with('failed','Failed to delete goals.');
    }
}
}
