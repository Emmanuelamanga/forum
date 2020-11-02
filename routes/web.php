<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use PHPUnit\TextUI\XmlConfiguration\Group;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['middleware' => 'auth'], function () {
    Route::get('/counties', function () {
        $jsonString = file_get_contents(base_path('resources/lang/en/counties.json'));
        return json_decode($jsonString, true);
    });
// get homegroup page
    Route::get('/homegroup', function () {
        return view('homegroup');
    });
// get users by county api
    Route::get('users/{county}', function ($county) {
      $users =  User::where('hometown', $county)->get();
        return json_encode($users);
    });

});

