<?php

namespace App\Http\Controllers\Access;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Spatie\Permission\Models\Role;
use App\Http\Resources\APIResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
	public function index()
	{
		return view('back.content.access.role', [
			"title" => "User Roles",
			"css"	=> ['datatable'],
			"js"	=> 'access/roleJs',
		]);
	}

	public function store(Request $request)
	{
		$validator = Validator::make(
			$request->all(),
			[
				"name" => ["required", "unique:roles"],
			],
			[
				'name.required' => '&nbsp; Role name is required',
				'name.unique' => '&nbsp; Role name already registered',
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
			Role::create($request->all());
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
				"name" => ["required", "unique:roles,name," . $id],
			],
			[
				'name.required' => '&nbsp; Role name is required',
				'name.unique' => '&nbsp; Role name already registered',
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
			$role = Role::findOrFail($id);
			$role->update($request->all());
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
		$data = Role::all();

		return DataTables::of($data)
			->addColumn('aksi', function ($data) use ($user) {
				$aksi = "<div class='float-right'>";

				if ($user->can('edit roles')) {
					$aksi .= "<a href='javascript:void(0)' class='btn btn-sm btn-secondary mb-1 mx-1 edit' data-id='" . $data->id . "' data-name='" . $data->name . "'>Edit</a>";
				}
				if ($user->can('delete roles')) {
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
		$role = Role::findOrFail($id);

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
			$role->delete();
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
