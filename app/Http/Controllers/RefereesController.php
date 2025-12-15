<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class RefereesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $referees = DB::table('Referees')->get();
        return view('referees.index',compact('referees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = DB::table('Countries')->get();
        return view('referees.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'referee_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'country_id' => 'required',
        ]);
        try{
        DB::table('Referees')->insert([
            'referee_id' => $request->referee_id,
            'first_name' => $request->first_name,
            'last_name' =>  $request->last_name,
            'country_id' =>  $request->country_id,
        ]);
        return redirect()->route('referees.index')->with('success','Referees create successfully.');
        } catch (\Exception $e) {
            return redirect()->route('referees.index')->with('failed', 'Failed to create referees.');
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
        $referees = DB::table('Referees')->where('referee_id',$id)->get();
        $countries = DB::table('Countries')->get();
        return view('referees.edit', compact('referees', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'country_id' => 'required',
        ]);
        try{
        DB::table('Referees')->where('referee_id',$id)->update([
            'first_name' => $request->first_name,
            'last_name' =>  $request->last_name,
            'country_id' =>  $request->country_id,
        ]);
        return redirect()->route('referees.index')->with('success','Referees updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('referees.index')->with('failed', 'Failed to update referees.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
        DB::table('Referees')->where('referee_id',$id)->delete();
        return redirect()->route('referees.index')->with('success','Referees deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('referees.index')->with('failed', 'Failed to delete referees.');
        }
    }
}
