<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\articles\UserController;
use App\Http\Controllers\Api\articles\MentorController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    dd(Auth::guard('mentor')->check());
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/mentor', function (Request $request) {
    return 'bnjr';
});

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);


Route::post('registerMentor', [MentorController::class, 'registerMentor']);

Route::post('login', [MentorController::class, 'login']);


Route::post('logout', [MentorController::class, 'logout']);


Route::middleware(['auth:sanctum', 'acces:mentor'])->group(function () {
    /*routes d'acces pour mentors*/
    
});

Route::middleware(['auth:sanctum', 'acces:user'])->group(function () {
    /*routes d'acces pour mentorés*/
    Route::post('logoutUser', [UserController::class, 'logoutUser']);

});

Route::middleware(['auth:sanctum', 'acces:admin'])->group(function () {
    /*routes d'acces pour admin*/
    /*routes de basse*/
 

});



/*routes pour <notes></notes>*/
// Route::post('store',[NoteController::class,'store']);
// Route::post('notes/{note}/update',[NoteController::class,'update']);
// Route::post('notes/{note}/destroy',[NoteController::class,'destroy']);
