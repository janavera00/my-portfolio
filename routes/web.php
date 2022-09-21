<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkController;
use Illuminate\Support\Facades\Route;

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

Route::controller([UserController::class])->group(function () {
    Route::get('/', 'home');

    Route::get('/login', 'index');
    Route::post('/login/authenticate', 'authenticate');
    Route::get('/logout', 'destroy');
    Route::post('/editAbout', 'editAboutMe');
    Route::post('/updateSkills', 'updateSkills');
    Route::post('/updateEduc', 'updateEduc');
    Route::post('/updateExperience', 'updateExperience');
});

Route::post('/addWork', [WorkController::class, 'create']);
