<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Spatie\Permission\Models\Role;
use App\Http\Resources\APIResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
			->addColumn('aksi', function ($data) use ($user) {
				$aksi = "<div class='float-right'>";

				if ($user->can('edit skt')) {
					$aksi .= "<a href='javascript:void(0)' data-id='" . $data['id'] . "' class='btn btn-sm btn-secondary mb-1 mx-1 edit'>Edit</a>";
				}
				if ($user->can('delete skt')) {
					$aksi .= " <a href='javascript:void(0)' data-id='" . $data['id'] . "' class='btn btn-sm btn-danger mb-1 mx-1 hapus'>Delete</a>";
				}

				return $aksi .= "</div>";
			})
			->addColumn('level', function ($s) {
				$has_roles = [];

				foreach ($s->roles as $val) {
					$has_roles[] = $val->name;
				}
				return implode(', ', $has_roles);
			})
			->rawColumns(['aksi', 'level'])
			->addIndexColumn()
			->toJson();
	}

	public function show(int $id)
	{
		try {
			$data = User::with('roles')->find($id);
			return response()->json(
				new APIResponse(
					true,
					"Data pengguna ditemukan",
					$data
				),
				201
			);
		} catch (\Throwable $th) {
			return response()->json(
				new APIResponse(
					false,
					$th->getMessage()
				),
				500
			);
		}
	}

	public function store(Request $request)
	{
		$validator = Validator::make(
			$request->all(),
			[
				"name" => ["required"],
				"username" => ["required", "unique:users,username"],
				"password" => ["nullable", "confirmed"],
				"id_role" => ["required"],
			],
			[
				"name.required" => "wajib diisi",
				"username.required" => "wajib diisi",
				"username.unique" => "username sudah terdaftar",
				"password.confirmed" => "password tidak cocok",
				"id_role.required" => "wajib diisi",
			]
		);

		if ($validator->fails()) {
			return response()->json(
				new APIResponse(
					false,
					"Invalid input",
					$validator->errors()->toArray()
				),
				422
			);
		}

		$data = array(
			'name' => $request->name,
			'username' => $request->username,
			'password' => Hash::make($request->password),
		);

		try {
			$user = User::create($data);
			$user->syncRoles($request->id_role);
			return response()->json(
				new APIResponse(
					true,
					"Data pengguna berhasil disimpan",
					$request->all()
				),
				201
			);
		} catch (\Throwable $th) {
			return response()->json(
				new APIResponse(
					false,
					$th->getMessage()
				),
				500
			);
		}
	}

	public function update(Request $request, int $id)
	{
		$validator = Validator::make(
			$request->all(),
			[
				"name" => ["required"],
				"username" => ["required", "unique:users,username," . $id],
				"password" => ["nullable", "confirmed"],
				"id_role" => ["required"],
			],
			[
				"name.required" => "wajib diisi",
				"username.required" => "wajib diisi",
				"username.unique" => "username sudah terdaftar",
				"password.confirmed" => "password tidak cocok",
				"id_role.required" => "wajib diisi",
			]
		);

		if ($validator->fails()) {
			return response()->json(
				new APIResponse(
					false,
					"Invalid input",
					$validator->errors()->toArray()
				),
				422
			);
		}

		// var_dump($request->all());
		// die;

		$data = array(
			'name' => $request->name,
			'username' => $request->username
		);

		if ($request->password) {
			$data['password'] = Hash::make($request->password);
		}

		try {
			$user = User::findOrFail($id);
			$user->update($data);
			$user->syncRoles($request->id_role);
			return response()->json(
				new APIResponse(
					true,
					"Data pengguna berhasil diperbaharui",
					$request->all()
				),
				201
			);
		} catch (\Throwable $th) {
			return response()->json(
				new APIResponse(
					false,
					$th->getMessage()
				),
				500
			);
		}
	}

	public function destroy(int $id)
	{
		$user = User::find(Auth::user()->id);
		$data = User::findOrFail($id);

		if (!$user->can('delete user')) {
			return response()->json(
				new APIResponse(
					false,
					"access to the requested resource is forbidden"
				),
				403
			);
		}

		try {
			$data->delete();
			return response()->json(
				new APIResponse(
					true,
					"Data pengguna telah dihapus",
				),
				200
			);
		} catch (\Throwable $th) {
			return response()->json(
				new APIResponse(
					false,
					$th->getMessage()
				),
				500
			);
		}
	}
}
