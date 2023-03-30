<?php

namespace App\Http\Controllers\Access;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Spatie\Permission\Models\Permission;
use App\Http\Resources\APIResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
	public function index()
	{
		return view('back.content.access.permission', [
			"title" => "User Permissions",
			"css"	=> ['datatable'],
			"js"	=> 'access/permissionJs',
		]);
	}

	public function store(Request $request)
	{
		$validator = Validator::make(
			$request->all(),
			[
				"name" => ["required", "unique:permissions"],
			],
			[
				'name.required' => '&nbsp; Permission name is required',
				'name.unique' => '&nbsp; Permission name already registered',
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
			Permission::create($request->all());
			return response()->json(
				new APIResponse(
					true,
					"Data stored!",
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
				"name" => ["required", "unique:permissions,name," . $id],
			],
			[
				'name.required' => '&nbsp; Permission name is required',
				'name.unique' => '&nbsp; Permission name already registered',
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
			$Permission = Permission::findOrFail($id);
			$Permission->update($request->all());
			return response()->json(
				new APIResponse(
					true,
					"Data stored!",
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

	public function dttable()
	{
		$user = User::find(Auth::user()->id);
		$data = Permission::all();

		return DataTables::of($data)
			->addColumn('aksi', function ($data) use ($user) {
				$aksi = "<div class='float-right'>";

				if ($user->can('edit Permissions')) {
					$aksi .= "<a href='javascript:void(0)' class='btn btn-sm btn-secondary mb-1 mx-1 edit' data-id='" . $data->id . "' data-name='" . $data->name . "'>Edit</a>";
				}
				if ($user->can('delete Permissions')) {
					$aksi .= " <a href='javascript:void(0)' data-id='" . $data->id . "' class='btn btn-sm btn-danger mb-1 mx-1 hapus'>Delete</a>";
				}

				return $aksi .= "</div>";
			})
			->rawColumns(['aksi'])
			->addIndexColumn()
			->toJson();
	}

	public function destroy(int $id)
	{
		$user = User::find(Auth::user()->id);
		$Permission = Permission::findOrFail($id);

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
			$Permission->delete();
			return response()->json(
				new APIResponse(
					true,
					"Data deleted",
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
