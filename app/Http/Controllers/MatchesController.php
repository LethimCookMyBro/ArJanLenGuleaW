<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class MatchesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $matches = DB::table('Matches')->get();
        return view('matches/index', compact('matches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $stadiums = DB::table('Stadiums')->get();
        $teams = DB::table('Teams')->get();
        return view('matches/create', compact('stadiums', 'teams'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'match_id' => 'required',
            'stadium_id' => 'required',
            'team1_id' => 'required',
            'team2_id' => 'required',
            'match_date' => 'required',
            'match_time' => 'required',
            'stage' => 'required',
        ]);
        try{
        DB::table('Matches')->insert([
            'match_id' => $request->match_id,
            'stadium_id' => $request->stadium_id,
            'team1_id' => $request->team1_id,
            'team2_id' => $request->team2_id,
            'match_date' => $request->match_date,
            'match_time' => $request->match_time,
            'stage' => $request->stage,
        ]);

        return redirect()->route('matches.index')->with('success', 'Match created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('matches.index')->with('failed', 'Failed to create match.');
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
        $stadiums = DB::table('Stadiums')->get();
        $teams = DB::table('Teams')->get();
        $matches = DB::table('Matches')->where('match_id', $id)->get();
        return view('matches/edit', compact('matches', 'stadiums', 'teams'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([       
            'stadium_id' => 'required',
            'team1_id' => 'required',
            'team2_id' => 'required',
            'match_date' => 'required',
            'match_time' => 'required',
            'stage' => 'required',
          
        ]);
        try{
        DB::table('Matches')->where('match_id', $id)->update([
            'stadium_id' => $request->stadium_id,
            'team1_id' => $request->team1_id,
            'team2_id' => $request->team2_id,
            'match_date' => $request->match_date,
            'match_time' => $request->match_time,
            'stage' => $request->stage,
        ]);

        return redirect()->route('matches.index')->with('success', 'Match updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('matches.index')->with('failed', 'Failed to update match.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
        DB::table('Matches')->where('match_id', $id)->delete();
        return redirect()->route('matches.index')->with('success', 'Match deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('matches.index')->with('failed', 'Failed to delete match.');
        }
    }
}
