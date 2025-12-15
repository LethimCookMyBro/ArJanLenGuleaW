<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class CountriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $countries = DB::table('Countries')->get();
        return view('countries.index',compact('countries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('countries/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
       $request->validate([
            'country_id' => 'required',
            'country_name' => 'required',
            'continent' => 'required',
            'fifa_ranking' => 'required',
        ]);
        try {
        DB::table('Countries')->insert([
             'country_id' => $request->country_id,
             'country_name' => $request->country_name,
             'continent' =>  $request->continent,
             'fifa_ranking' =>  $request->fifa_ranking,
        ]);
        return redirect()->route('countries.index')->with('success','Countriest create successfully.');
        }catch (\Exception $e) {
            return redirect()->route('countries.index')->with('failed','Failed to create country.');
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
        $countries = DB::table('Countries')->where('country_id',$id)->get();
        return view('countries/edit',compact('countries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         $request->validate([
            'country_name' => 'required',
            'continent' => 'required',
            'fifa_ranking' => 'required',
        ]);
        try{
         DB::table('Countries')->where('country_id',$id)->update([
            'country_name' => $request->country_name,
            'continent' =>  $request->continent,
            'fifa_ranking' =>  $request->fifa_ranking,
        ]);
         return redirect()->route('countries.index')->with('success','Countries update successfully.');
        }catch (\Exception $e) {
            return redirect()->route('countries.index')->with('failed','Failed to update country.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
        DB::table('Countries')->where('country_id',$id)->delete();
        return redirect()->route('countries.index')->with('success','Countries deleted successfully.');
        }catch(\Exception $e){
            return redirect()->route('countries.index')->with('failed','Failed to delete country.');
    }
}
}
