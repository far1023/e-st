<?php

namespace App\Http\Controllers\Access;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Spatie\Permission\Models\Role;
use App\Http\Resources\APIResponse;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class RoleHasPermissionController extends Controller
{
	public function index()
	{
		return view('back/content/access/roleHasPermission', [
			"permissions" => Permission::all(),
			"title" => "Role has Permission",
			"css"	=> ['datatable', 'select2'],
			"js"	=> 'access/roleHasPermissionJs',
		]);
	}

	public function update(Request $request)
	{
		$validator = Validator::make(
			$request->all(),
			[
				'name' => ['required'],
			],
			[
				'name.required' => '&ndatap; Role name is required',
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

		try {
			Role::find($request->id)->syncPermissions($request->id_permission);
			return response()->json(
				new APIResponse(
					true,
					"Permission granted!",
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

	public function show(int $id)
	{
		try {
			$role = Role::find($id);
			$permission = $role->getAllPermissions();

			$data = [
				'role' => $role,
				'permission' => $permission
			];

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

	public function dttable()
	{
		return DataTables::of(Role::where('name', '!=', 'superadmin')->with('permissions')->get())
			->addColumn('role', function ($data) {
				return $data->name;
			})
			->addColumn('has_permission', function ($data) {
				$has_permissions = [];
				foreach ($data->permissions as $val) {
					$has_permissions[] = "<span class='badge badge-dark fw-bolder my-1'>" . $val->name . "</span>";
				}
				return implode(' ', $has_permissions);
			})
			->addColumn('aksi', function ($data) {
				$aksi = "<div class='float-right'>";

				$aksi .= "<a href='javascript:void(0)' class='btn btn-sm btn-secondary mb-1 mx-1 edit' data-id='" . $data->id . "' data-name='" . $data->name . "'>Edit</a>";

				return $aksi .= "</div>";
			})
			->rawColumns(['aksi', 'role', 'has_permission'])
			->addIndexColumn()
			->toJson();
	}
}
