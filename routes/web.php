<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GantiRugiController;
use App\Http\Controllers\KepemilikanTanahController;
use App\Http\Controllers\VignereController;

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
		"js"	=> 'tes/vignerejs'
	]);
	Route::post('/tes-vignere/cipher', [VignereController::class, 'cipher']);

	Route::prefix('formulir')->group(function () {
		Route::get('/ganti-rugi', [GantiRugiController::class, 'create'])->name('ganti-rugi.create');
		Route::post('/ganti-rugi', [GantiRugiController::class, 'store'])->name('ganti-rugi.store');
		Route::get('/ganti-rugi/{id}/edit', [GantiRugiController::class, 'edit'])->name('ganti-rugi.edit');
		Route::put('/ganti-rugi/{id}/update', [GantiRugiController::class, 'update'])->name('ganti-rugi.update');
	});

	Route::prefix('data')->group(function () {
		Route::get('/ganti-rugi', [GantiRugiController::class, 'data'])->name('ganti-rugi.index');
		Route::get('/ganti-rugi/dttable', [GantiRugiController::class, 'dttable']);
		Route::get('/ganti-rugi/{id}', [GantiRugiController::class, 'show'])->name('ganti-rugi.show');
		Route::delete('/ganti-rugi/{id}', [GantiRugiController::class, 'destroy'])->name('ganti-rugi.destroy');

		Route::resource('/kepemilikan-tanah', KepemilikanTanahController::class);
	});
});
