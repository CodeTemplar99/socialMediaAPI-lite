<?php

use Illuminate\Support\Facades\Route;
use App\Models\Question;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $quesions = Question::orderBy('created_at', 'desc')->get();
    return response()->json(['quesions'=> $quesions]);
});
