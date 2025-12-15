<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class PlayersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $players = DB::table('Players')->get();
        return view('players.index', compact('players'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teams = DB::table('Teams')->get();
        return view('players.create', compact('teams'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'player_id' => 'required',
            'team_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'position' => 'required',
            'jersey_number' => 'required',
            'date_of_birth' => 'required',
        ]);
        try{
        DB::table('Players')->insert([
            'player_id' => $request->player_id,
            'team_id' => $request->team_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'position' => $request->position,
            'jersey_number' => $request->jersey_number,
            'date_of_birth' => $request->date_of_birth,
        ]);

        return redirect()->route('players.index')->with('success', 'Player created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('players.index')->with('failed', 'Failed to create player.');
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
        $players = DB::table('Players')->where('player_id', $id)->get();
        $teams = DB::table('Teams')->get();
        return view('players.edit', compact('players', 'teams'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'team_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'position' => 'required',
            'jersey_number' => 'required',
            'date_of_birth' => 'required',
        ]);
        try{
        DB::table('Players')->where('player_id', $id)->update([
            'team_id' => $request->team_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'position' => $request->position,
            'jersey_number' => $request->jersey_number,
            'date_of_birth' => $request->date_of_birth,
        ]);

        return redirect()->route('players.index')->with('success', 'Player updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('players.index')->with('failed', 'Failed to update player.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {   
        try{
        DB::table('Players')->where('player_id', $id)->delete();
        return redirect()->route('players.index')->with('success', 'Player deleted successfully.');
    } catch (\Exception $e) {
        return redirect()->route('players.index')->with('failed', 'Failed to deleted player.');
    }
    }
}
