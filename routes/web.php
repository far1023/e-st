<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VignereController;

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
	return view('login');
});
Route::get('/login', function () {
	return view('login');
})->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);

Route::get('/tes', [TesController::class, 'index']);

Route::group(['middleware' => ['auth']], function () {
	Route::view('/beranda', 'back/content/beranda', [
		"title" => "Beranda",
		"css"	=> [],
		"js"	=> NULL
	]);

	Route::view('/tes-vignere', 'back/content/tes/vignere', [
		"title" => "Tes",
		"css"	=> [],
		"js"	=> 'vignerejs'
	]);
	Route::post('/tes-vignere/cipher', [VignereController::class, 'cipher']);
});
