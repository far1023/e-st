<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Rules\Recaptcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
	public function login(Request $request)
	{
		$request->validate(
			[
				'username' => ['required', 'max:255'],
				'password' => ['required'],
				'g-recaptcha-response' => ['required', new Recaptcha()]
			],
			[
				'username.required' => ' Kolom Nama Pengguna wajib diisi',
				'username.max' => ' Kolom Nama Pengguna melebihi panjang karakter (255)',
				'password.required' => ' Kolom Password wajib diisi',
			]
		);

		if (User::where('username', $request->username)->first()) {
			if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
				$request->session()->regenerate();
				return redirect()->intended('beranda');
			}
		}

		return back()->with([
			'loginError' => 'Nama pengguna atau kata sandi salah',
		])->withInput();
	}

	public function logout(Request $request)
	{
		$request->session()->flush();
		return redirect()->intended('/');
	}
}
