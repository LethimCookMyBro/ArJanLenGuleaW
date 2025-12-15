<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlayersController;
use App\Http\Controllers\TeamsController;
use App\Http\Controllers\MatchesController;
use App\Http\Controllers\CountriesController;
use App\Http\Controllers\StadiumsController;
use App\Http\Controllers\GoalsController;
use App\Http\Controllers\RefereesController;
use App\Http\Controllers\MatchRefereesController;

Route::resource('players', PlayersController::class); 
Route::resource('teams', TeamsController::class); 
Route::resource('matches', MatchesController::class); 
Route::resource('countries', CountriesController::class);
Route::resource('stadiums', StadiumsController::class);
Route::resource('goals', GoalsController::class);
Route::resource('referees', RefereesController::class);
Route::resource('matchreferees', MatchRefereesController::class);

Route::get('/', [PlayersController::class, 'index']);