<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class StadiumsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stadiums = DB::table('Stadiums')->get();
        return view('stadiums/index',compact('stadiums'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('stadiums/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'stadium_id' => 'required',
            'stadium_name' => 'required',
            'city' => 'required',
            'capacity' => 'required',
        ]);
        try{
        DB::table('Stadiums')->insert([
             'stadium_id' => $request->stadium_id,
             'stadium_name' => $request->stadium_name,
             'city' =>  $request->city,
             'capacity' =>  $request->capacity,
        ]);

        return redirect()->route('stadiums.index')->with('success','Stadiums create successfully.');
        }catch(\Exception $e){
            return redirect()->route('stadiums.index')->with('failed','Failed to create stadiums.');
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
        $stadiums = DB::table('Stadiums')->where('stadium_id',$id)->get();
        return view('stadiums/edit',compact('stadiums'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'stadium_name' => 'required',
            'city' => 'required',
            'capacity' => 'required',
        ]);
        try{
        DB::table('Stadiums')->where('stadium_id',$id)->update([
            'stadium_name' => $request->stadium_name,
            'city' =>  $request->city,
            'capacity' =>  $request->capacity,
        ]);
        return redirect()->route('stadiums.index')->with('success','Stadiums update successfully.');
        }catch(\Exception $e){
            return redirect()->with('failed','Failed to update stadiums.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
        DB::table('Stadiums')->where('stadium_id',$id)->delete();
        return redirect()->route('stadiums.index')->with('success','Stadiums delete successfully.');
        }catch(\Exception $e){
            return redirect()->route('stadiums.index')->with('failed','Failed to delete stadiums.');
        }
    }
}
