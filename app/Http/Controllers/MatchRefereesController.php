<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class MatchRefereesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $matchreferees = DB::table('MatchReferees')->get();
        return view('matchreferees/index', compact('matchreferees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $matches = DB::table('Matches')->get();
        $referees = DB::table('Referees')->get();
        return view('matchreferees.create', compact('matches', 'referees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'match_referee_id' => 'required',
            'match_id' => 'required',
            'referee_id' => 'required',
            'role' => 'required',
        ]);
        try{
        DB::table('MatchReferees')->insert([
            'match_referee_id' => $request->match_referee_id,
            'match_id' => $request->match_id,
            'referee_id' => $request->referee_id,
            'role' => $request->role,
        ]);

        return redirect()->route('matchreferees.index')->with('success', 'Match referees created successfully.');
        }catch (\Exception $e) {
            return redirect()->route('matchreferees.index')->with('failed', 'Failed to create match referees.');
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
        $matchreferees = DB::table('MatchReferees')->where('match_referee_id', $id)->get();
        $matches = DB::table('Matches')->get();
        $referees = DB::table('Referees')->get();
        return view('matchreferees.edit', compact('matchreferees', 'matches', 'referees'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'match_referee_id' => 'required',
            'match_id' => 'required',
            'referee_id' => 'required',
            'role' => 'required',
        ]);
        try{
        DB::table('MatchReferees')->where('match_referee_id', $id)->update([
            'match_referee_id' => $request->match_referee_id,
            'match_id' => $request->match_id,
            'referee_id' => $request->referee_id,
            'role' => $request->role,
        ]);

        return redirect()->route('matchreferees.index')->with('success', 'Match referees updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('matchreferees.index')->with('failed', 'Failed to update match referees.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
        DB::table('MatchReferees')->where('match_referee_id', $id)->delete();
        return redirect()->route('matchreferees.index')->with('success', 'Match referees deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('matchreferees.index')->with('failed', 'Failed to delete match referees.');
        }
    }
}
