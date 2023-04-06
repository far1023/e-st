<?php

namespace App\Http\Controllers;

use App\Models\User;
use Yajra\DataTables\DataTables;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
	public function index()
	{
		return view('back/content/user', [
			// "roles" => Role::all()->where('id', '!=', 1),
			"roles" => Role::all(),
			"title" => "Data Pengguna Sistem",
			"css"	=> ['datatable'],
			"js"	=> 'userjs',
		]);
	}

	public function dttable()
	{
		$user = User::find(Auth::user()->id);

		$data = User::with('roles')->where('id', '!=', 1);
		// $data = User::with('roles');

		return DataTables::of($data->get())
			->addColumn('level', function ($s) {
				$has_roles = [];

				foreach ($s->roles as $val) {
					$has_roles[] = $val->name;
				}
				return implode(', ', $has_roles);
			})
			->rawColumns(['level'])
			->addIndexColumn()
			->toJson();
	}
}
