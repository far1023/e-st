<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GantiRugiController;
use App\Http\Controllers\KepemilikanTanahController;
use App\Http\Controllers\PetaSituasiTanahController;
use App\Http\Controllers\SuratSituasiTanahController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VignereController;
use App\Http\Controllers\Access\RoleController;
use App\Http\Controllers\Access\PermissionController;
use App\Http\Controllers\Access\RoleHasPermissionController;

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

	Route::get('/pengguna/dttable', [UserController::class, 'dttable']);
	Route::resource('/pengguna', UserController::class);

	Route::view('/tes-vignere', 'back/content/tes/vignere', [
		"title" => "Tes",
		"css"	=> [],
		"js"	=> 'tes/vignerejs'
	]);
	Route::post('/tes-vignere/cipher', [VignereController::class, 'cipher']);

	Route::prefix('formulir')->group(function () {
		Route::get('/ganti-rugi', [GantiRugiController::class, 'create'])->name('gantiRugi.create');
		Route::post('/ganti-rugi', [GantiRugiController::class, 'store'])->name('gantiRugi.store');
		Route::get('/ganti-rugi/{id}/edit', [GantiRugiController::class, 'edit'])->name('gantiRugi.edit');
		Route::put('/ganti-rugi/{id}/update', [GantiRugiController::class, 'update'])->name('gantiRugi.update');

		Route::get('/kepemilikan-tanah', [KepemilikanTanahController::class, 'create'])->name('kepemilikanTanah.create');
		Route::post('/kepemilikan-tanah', [KepemilikanTanahController::class, 'store'])->name('kepemilikanTanah.store');
		Route::get('/kepemilikan-tanah/{id}/edit', [KepemilikanTanahController::class, 'edit'])->name('kepemilikanTanah.edit');
		Route::put('/kepemilikan-tanah/{id}/update', [KepemilikanTanahController::class, 'update'])->name('kepemilikanTanah.update');

		Route::get('/peta-situasi-tanah', [PetaSituasiTanahController::class, 'create'])->name('petaSituasi.create');
		Route::post('/peta-situasi-tanah', [PetaSituasiTanahController::class, 'store'])->name('petaSituasi.store');
		Route::get('/peta-situasi-tanah/{id}/edit', [PetaSituasiTanahController::class, 'edit'])->name('petaSituasi.edit');
		Route::put('/peta-situasi-tanah/{id}/update', [PetaSituasiTanahController::class, 'update'])->name('petaSituasi.update');

		Route::get('/surat-situasi-tanah', [SuratSituasiTanahController::class, 'create'])->name('suratSituasi.create');
		Route::post('/surat-situasi-tanah', [SuratSituasiTanahController::class, 'store'])->name('suratSituasi.store');
		Route::get('/surat-situasi-tanah/{id}/edit', [SuratSituasiTanahController::class, 'edit'])->name('suratSituasi.edit');
		Route::put('/surat-situasi-tanah/{id}/update', [SuratSituasiTanahController::class, 'update'])->name('suratSituasi.update');
	});

	Route::prefix('data')->group(function () {
		Route::get('/ganti-rugi/dttable', [GantiRugiController::class, 'dttable']);
		Route::get('/ganti-rugi', [GantiRugiController::class, 'data'])->name('gantiRugi.index');
		Route::get('/ganti-rugi/{id}', [GantiRugiController::class, 'show'])->name('gantiRugi.show');
		Route::delete('/ganti-rugi/{id}', [GantiRugiController::class, 'destroy'])->name('gantiRugi.destroy');

		Route::get('/kepemilikan-tanah/dttable', [KepemilikanTanahController::class, 'dttable']);
		Route::get('/kepemilikan-tanah', [KepemilikanTanahController::class, 'data'])->name('kepemilikanTanah.index');
		Route::get('/kepemilikan-tanah/{id}', [KepemilikanTanahController::class, 'show'])->name('kepemilikanTanah.show');
		Route::delete('/kepemilikan-tanah/{id}', [KepemilikanTanahController::class, 'destroy'])->name('kepemilikanTanah.destroy');

		Route::get('/peta-situasi-tanah/dttable', [PetaSituasiTanahController::class, 'dttable']);
		Route::get('/peta-situasi-tanah', [PetaSituasiTanahController::class, 'data'])->name('petaSituasi.index');
		Route::get('/peta-situasi-tanah/{id}', [PetaSituasiTanahController::class, 'show'])->name('petaSituasi.show');
		Route::delete('/peta-situasi-tanah/{id}', [PetaSituasiTanahController::class, 'destroy'])->name('petaSituasi.destroy');

		Route::get('/surat-situasi-tanah/dttable', [SuratSituasiTanahController::class, 'dttable']);
		Route::get('/surat-situasi-tanah', [SuratSituasiTanahController::class, 'data'])->name('suratSituasi.index');
		Route::get('/surat-situasi-tanah/{id}', [SuratSituasiTanahController::class, 'show'])->name('suratSituasi.show');
		Route::delete('/surat-situasi-tanah/{id}', [SuratSituasiTanahController::class, 'destroy'])->name('suratSituasi.destroy');

		Route::get('/ganti-rugi/{id}/cek', [GantiRugiController::class, 'printOut'])->name('gantiRugi.cek');
		Route::get('/kepemilikan-tanah/{id}/cek', [KepemilikanTanahController::class, 'printOut'])->name('kepemilikanTanah.cek');
		Route::get('/peta-situasi-tanah/{id}/cek', [PetaSituasiTanahController::class, 'printOut'])->name('petaSituasi.cek');
		Route::get('/surat-situasi-tanah/{id}/cek', [SuratSituasiTanahController::class, 'printOut'])->name('suratSituasi.cek');
	});

	Route::group(['middleware' => ['role:superadmin']], function () {
		Route::prefix('controls')->group(function () {
			Route::get('/roles/dttable', [RoleController::class, 'dttable']);
			Route::resource('/roles', RoleController::class);

			Route::get('/permissions/dttable', [PermissionController::class, 'dttable']);
			Route::resource('/permissions', PermissionController::class);

			Route::get('/access-granting/dttable', [RoleHasPermissionController::class, 'dttable']);
			Route::resource('/access-granting', RoleHasPermissionController::class);
		});
	});
});
