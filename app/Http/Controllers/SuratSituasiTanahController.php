<?php

namespace App\Http\Controllers;

use VignereCip;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\SuratSituasiTanah;
use Yajra\DataTables\DataTables;
use App\Http\Resources\APIResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SuratSituasiTanahController extends Controller
{
	public function data()
	{
		return view('back.content.data.suratSituasi', [
			"title" => "Data Surat Situasi Tanah",
			"css"	=> ['datatable'],
			"js"	=> 'data/suratSituasiJs'
		]);
	}

	public function dttable()
	{
		$user = User::find(Auth::user()->id);

		// $data = User::with('roles')->where('id', '!=', 1);
		$data = SuratSituasiTanah::latest()->get()->toArray();

		foreach ($data as $i => $value) {
			foreach ($value as $j => $val) {
				if (!is_int($val)) {
					$value[$j] = VignereCip::decrypt($val);
				}
			}
			$data[$i] = $value;
		}

		return DataTables::of($data)
			->addColumn('aksi', function ($data) use ($user) {
				$aksi = "";

				if ($user->can('edit skt')) {
					$aksi .= "<a href='javascript:void(0)' data-id='" . $data['id'] . "' class='btn btn-sm btn-secondary mb-1 mx-1 edit'>Edit</a>";
				}
				if ($user->can('delete skt')) {
					$aksi .= " <a href='javascript:void(0)' data-id='" . $data['id'] . "' class='btn btn-sm btn-danger mb-1 mx-1 hapus'>Delete</a>";
				}

				return $aksi;
			})
			->rawColumns(['aksi'])
			->addIndexColumn()
			->toJson();
	}

	public function show(int $id)
	{
		try {
			$data = SuratSituasiTanah::findOrFail($id);
			return response()->json(
				new APIResponse(
					true,
					"Data Situasi Tanah ditemukan",
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

	public function create()
	{
		return view('back.content.formulir.formSuratSituasi', [
			"title" => "Formulir Peta Situasi Tanah",
			"css"	=> ['stepper', 'datepicker'],
			"js"	=> 'formulir/addSuratSituasiJs'
		]);
	}

	public function store(Request $request)
	{
		$validator = Validator::make(
			$request->all(),
			[
				"jalan_gang" => ["required"],
				"rt" => ["required"],
				"rw" => ["required"],
				"desa" => ["required"],
				"kecamatan" => ["required"],
				"kabupaten" => ["required"],
				"luas_tanah" => ["required", "integer"],
				"atas_nama" => ["required"],
				"sketsa" => ["nullable", "mimes:jpg,jpeg,png", "max:2048"],
				"jabatan_saksi_satu" => ["required_with:nama_saksi_satu"],
				"jabatan_saksi_dua" => ["required_with:nama_saksi_dua"],
				"jabatan_saksi_tiga" => ["required_with:nama_saksi_tiga"],
			],
			[
				"jalan_gang.required" => "wajib diisi",
				"rt.required" => "wajib diisi",
				"rw.required" => "wajib diisi",
				"desa.required" => "wajib diisi",
				"kecamatan.required" => "wajib diisi",
				"kabupaten.required" => "wajib diisi",
				"luas_tanah.required" => "wajib diisi",
				"luas_tanah.integer" => "isikan hanya dengan bilangan bulat",
				"atas_nama" => "wajib diisi",
				"sketsa.mimes" => "jenis file yang diterima hanya jpg/jpeg/png",
				"sketsa.max" => "ukuran file maksimal 2MB",
				"jabatan_saksi_satu.required_with" => "isikan jabatan saksi satu",
				"jabatan_saksi_dua.required_with" => "isikan jabatan saksi dua",
				"jabatan_saksi_tiga.required_with" => "isikan jabatan saksi tiga",
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

		foreach ($request->all() as $key => $value) {
			$request[$key] = VignereCip::encrypt($value);
		}

		try {
			SuratSituasiTanah::create($request->all());
			return response()->json(
				new APIResponse(
					true,
					"Data Situasi Tanah berhasil disimpan",
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

	public function edit()
	{
		return view('back.content.formulir.formSuratSituasi', [
			"data" => NULL,
			"title" => "Formulir Peta Situasi Tanah - Edit",
			"css"	=> ['stepper', 'datepicker'],
			"js"	=> 'formulir/editSuratSituasiJs'
		]);
	}

	public function update(Request $request, int $id)
	{

		$validator = Validator::make(
			$request->all(),
			[
				"jalan_gang" => ["required"],
				"rt" => ["required"],
				"rw" => ["required"],
				"desa" => ["required"],
				"kecamatan" => ["required"],
				"kabupaten" => ["required"],
				"luas_tanah" => ["required", "integer"],
				"atas_nama" => ["required"],
				"sketsa" => ["nullable", "mimes:jpg,jpeg,png", "max:2048"],
				"jabatan_saksi_satu" => ["required_with:nama_saksi_satu"],
				"jabatan_saksi_dua" => ["required_with:nama_saksi_dua"],
				"jabatan_saksi_tiga" => ["required_with:nama_saksi_tiga"],
			],
			[
				"jalan_gang.required" => "wajib diisi",
				"rt.required" => "wajib diisi",
				"rw.required" => "wajib diisi",
				"desa.required" => "wajib diisi",
				"kecamatan.required" => "wajib diisi",
				"kabupaten.required" => "wajib diisi",
				"luas_tanah.required" => "wajib diisi",
				"luas_tanah.integer" => "isikan hanya dengan bilangan bulat",
				"atas_nama" => "wajib diisi",
				"sketsa.mimes" => "jenis file yang diterima hanya jpg/jpeg/png",
				"sketsa.max" => "ukuran file maksimal 2MB",
				"jabatan_saksi_satu.required_with" => "isikan jabatan saksi satu",
				"jabatan_saksi_dua.required_with" => "isikan jabatan saksi dua",
				"jabatan_saksi_tiga.required_with" => "isikan jabatan saksi tiga",
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

		foreach ($request->all() as $key => $value) {
			$request[$key] = VignereCip::encrypt($value);
		}

		try {
			$data = SuratSituasiTanah::findOrFail($id);
			$data->update($request->all());
			return response()->json(
				new APIResponse(
					true,
					"Data Situasi Tanah berhasil diperbaharui",
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
		$data = SuratSituasiTanah::findOrFail($id);

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
					"Data Situasi Tanah telah dihapus",
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
