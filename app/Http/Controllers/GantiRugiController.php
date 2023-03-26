<?php

namespace App\Http\Controllers;

use VignereCip;
use App\Models\Spgr;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Resources\APIResponse;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class GantiRugiController extends Controller
{
	public function index()
	{
		//
	}

	public function data()
	{
		return view('back.content.data.spgr', [
			"title" => "Data SPGR",
			"css"	=> ['datatable'],
			"js"	=> 'data/spgrjs'
		]);
	}

	public function dttable()
	{
		$user = User::find(Auth::user()->id);
		$data = Spgr::latest()->get()->toArray();

		foreach ($data as $i => $value) {
			foreach ($value as $j => $val) {
				if (!is_int($val)) {
					$value[$j] = VignereCip::decrypt($val);
				}
			}
			$data[$i] = $value;
		}
		// var_dump($data);
		// die;

		return DataTables::of($data)
			->addColumn('ttl', function ($data) {
				return $data['tempat_lahir_pihak_pertama'] . " / " . Carbon::parse($data['tanggal_lahir_pihak_pertama'])->isoFormat('DD/MM/Y');
			})
			->addColumn('aksi', function ($data) use ($user) {
				if ($user) {
					$aksi = "";

					if ($user->can('edit spgr')) {
						$aksi .= "<a href='" . url('formulir/ganti-rugi/' . $data['id'] . '/edit') . "' class='btn btn-sm btn-secondary mb-1 mx-1 edit'>Edit</a>";
					}
					if ($user->can('delete spgr')) {
						$aksi .= " <a href='javascript:void(0)' data-id='" . $data['id'] . "' class='btn btn-sm btn-danger mb-1 mx-1 hapus'>Delete</a>";
					}

					return $aksi;
				}

				return NULL;
			})
			->rawColumns(['ttl', 'aksi'])
			->addIndexColumn()
			->toJson();
	}

	public function show(int $id)
	{
		try {
			$data = Spgr::find($id)->toArray();
			foreach ($data as $key => $value) {
				if (!is_int($value)) {
					$data[$key] = VignereCip::decrypt($value);
				}
			}

			// dd($data);

			return response()->json(
				new APIResponse(
					true,
					"Data SPGR ditemukan",
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
		$data = Spgr::latest()->first();

		if ($data && explode('/', $data->no_reg)[2] == date('Y')) {
			$no_reg = intval(strtok($data->no_reg, '/')) + 1;
			$no_reg = $no_reg . "/SPGR/" . date('Y');
		} else {
			$no_reg = 1 . "/SPGR/" . date('Y');
		}

		return view('back.content.formulir.formspgr', [
			"no_reg" => $no_reg,
			"title" => "Formulir SPGR",
			"css"	=> ['stepper', 'datepicker'],
			"js"	=> 'formulir/spgrjs'
		]);
	}

	public function store(Request $request)
	{
		$request['besaran'] = str_replace(".", "", $request['besaran']);
		$request['no_reg'] = VignereCip::encrypt($request['no_reg']);

		$validator = Validator::make(
			$request->all(),
			[
				"no_reg" => ["required", "unique:spgrs"],
				"tanggal_ref" => ["nullable", "date"],
				"nama_pihak_pertama" => ["required"],
				"tempat_lahir_pihak_pertama" => ["required"],
				"tanggal_lahir_pihak_pertama" => ["required", "date"],
				"wn_pihak_pertama" => ["required"],
				"ktp_pihak_pertama" => ["required"],
				"alamat_pihak_pertama" => ["required"],
				"nama_pihak_kedua" => ["required"],
				"tempat_lahir_pihak_kedua" => ["required"],
				"tanggal_lahir_pihak_kedua" => ["required", "date"],
				"wn_pihak_kedua" => ["required"],
				"ktp_pihak_kedua" => ["required"],
				"alamat_pihak_kedua" => ["required"],
				"alamat_tanah" => ["required"],
				"luas_tanah" => ["required", "integer"],
				"besaran" => ["required", "integer"],
				"terbilang" => ["required"],
				"batas_utara" => ["required"],
				"ukuran_utara" => ["required", "integer"],
				"batas_selatan" => ["required"],
				"ukuran_selatan" => ["required", "integer"],
				"batas_barat" => ["required"],
				"ukuran_barat" => ["required", "integer"],
				"batas_timur" => ["required"],
				"ukuran_timur" => ["required", "integer"],
			],
			[
				"no_reg.required" => "wajib diisi",
				"no_reg.unique" => "nomor regis sudah terdaftar",
				"no_ref.date" => "format tanggal tidak cocok",
				"nama_pihak_pertama.required" => "wajib diisi",
				"tempat_lahir_pihak_pertama.required" => "wajib diisi",
				"tanggal_lahir_pihak_pertama.required" => "wajib diisi",
				"tanggal_lahir_pihak_pertama.date" => "format tanggal tidak cocok",
				"wn_pihak_pertama.required" => "wajib diisi",
				"ktp_pihak_pertama.required" => "wajib diisi",
				"alamat_pihak_pertama.required" => "wajib diisi",
				"nama_pihak_kedua.required" => "wajib diisi",
				"tempat_lahir_pihak_kedua.required" => "wajib diisi",
				"tanggal_lahir_pihak_kedua.required" => "wajib diisi",
				"tanggal_lahir_pihak_kedua.date" => "format tanggal tidak cocok",
				"wn_pihak_kedua.required" => "wajib diisi",
				"ktp_pihak_kedua.required" => "wajib diisi",
				"alamat_pihak_kedua.required" => "wajib diisi",
				"alamat_tanah.required" => "wajib diisi",
				"luas_tanah.required" => "wajib diisi",
				"luas_tanah.integer" => "isikan hanya dengan bilangan bulat",
				"besaran.required" => "wajib diisi",
				"besaran.integer" => "isikan hanya dengan bilangan bulat",
				"terbilang.required" => "wajib diisi",
				"batas_utara.required" => "wajib diisi",
				"ukuran_utara.required" => "wajib diisi",
				"ukuran_utara.integer" => "isikan hanya dengan bilangan bulat",
				"batas_selatan.required" => "wajib diisi",
				"ukuran_selatan.required" => "wajib diisi",
				"ukuran_selatan.integer" => "isikan hanya dengan bilangan bulat",
				"batas_barat.required" => "wajib diisi",
				"ukuran_barat.required" => "wajib diisi",
				"ukuran_barat.integer" => "isikan hanya dengan bilangan bulat",
				"batas_timur.required" => "wajib diisi",
				"ukuran_timur.required" => "wajib diisi",
				"ukuran_timur.integer" => "isikan hanya dengan bilangan bulat",
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

		$request['no_reg'] = VignereCip::decrypt($request['no_reg']);

		foreach ($request->all() as $key => $value) {
			$request[$key] = VignereCip::encrypt($value);
		}

		// var_dump($request->all());
		// die;

		try {
			Spgr::create($request->all());
			return response()->json(
				new APIResponse(
					true,
					"Data SPGR berhasil disimpan",
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

	public function edit(int $id)
	{
		$no_reg = Spgr::find($id)->no_reg;

		return view('back.content.formulir.formspgr', [
			"no_reg" => VignereCip::decrypt($no_reg),
			"title" => "Formulir SPGR - Edit",
			"css"	=> ['stepper', 'datepicker'],
			"js"	=> 'formulir/editspgrjs'
		]);
	}

	public function update(Request $request, int $id)
	{
		$request['besaran'] = str_replace(".", "", $request['besaran']);
		$request['no_reg'] = VignereCip::encrypt($request['no_reg']);

		$validator = Validator::make(
			$request->all(),
			[
				"no_reg" => ["required", "unique:spgrs,no_reg," . $id],
				"tanggal_ref" => ["nullable", "date"],
				"nama_pihak_pertama" => ["required"],
				"tempat_lahir_pihak_pertama" => ["required"],
				"tanggal_lahir_pihak_pertama" => ["required", "date"],
				"wn_pihak_pertama" => ["required"],
				"ktp_pihak_pertama" => ["required"],
				"alamat_pihak_pertama" => ["required"],
				"nama_pihak_kedua" => ["required"],
				"tempat_lahir_pihak_kedua" => ["required"],
				"tanggal_lahir_pihak_kedua" => ["required", "date"],
				"wn_pihak_kedua" => ["required"],
				"ktp_pihak_kedua" => ["required"],
				"alamat_pihak_kedua" => ["required"],
				"alamat_tanah" => ["required"],
				"luas_tanah" => ["required", "integer"],
				"besaran" => ["required", "integer"],
				"terbilang" => ["required"],
				"batas_utara" => ["required"],
				"ukuran_utara" => ["required", "integer"],
				"batas_selatan" => ["required"],
				"ukuran_selatan" => ["required", "integer"],
				"batas_barat" => ["required"],
				"ukuran_barat" => ["required", "integer"],
				"batas_timur" => ["required"],
				"ukuran_timur" => ["required", "integer"],
			],
			[
				"no_reg.required" => "wajib diisi",
				"no_reg.unique" => "nomor regis sudah terdaftar",
				"no_ref.date" => "format tanggal tidak cocok",
				"nama_pihak_pertama.required" => "wajib diisi",
				"tempat_lahir_pihak_pertama.required" => "wajib diisi",
				"tanggal_lahir_pihak_pertama.required" => "wajib diisi",
				"tanggal_lahir_pihak_pertama.date" => "format tanggal tidak cocok",
				"wn_pihak_pertama.required" => "wajib diisi",
				"ktp_pihak_pertama.required" => "wajib diisi",
				"alamat_pihak_pertama.required" => "wajib diisi",
				"nama_pihak_kedua.required" => "wajib diisi",
				"tempat_lahir_pihak_kedua.required" => "wajib diisi",
				"tanggal_lahir_pihak_kedua.required" => "wajib diisi",
				"tanggal_lahir_pihak_kedua.date" => "format tanggal tidak cocok",
				"wn_pihak_kedua.required" => "wajib diisi",
				"ktp_pihak_kedua.required" => "wajib diisi",
				"alamat_pihak_kedua.required" => "wajib diisi",
				"alamat_tanah.required" => "wajib diisi",
				"luas_tanah.required" => "wajib diisi",
				"luas_tanah.integer" => "isikan hanya dengan bilangan bulat",
				"besaran.required" => "wajib diisi",
				"besaran.integer" => "isikan hanya dengan bilangan bulat",
				"terbilang.required" => "wajib diisi",
				"batas_utara.required" => "wajib diisi",
				"ukuran_utara.required" => "wajib diisi",
				"ukuran_utara.integer" => "isikan hanya dengan bilangan bulat",
				"batas_selatan.required" => "wajib diisi",
				"ukuran_selatan.required" => "wajib diisi",
				"ukuran_selatan.integer" => "isikan hanya dengan bilangan bulat",
				"batas_barat.required" => "wajib diisi",
				"ukuran_barat.required" => "wajib diisi",
				"ukuran_barat.integer" => "isikan hanya dengan bilangan bulat",
				"batas_timur.required" => "wajib diisi",
				"ukuran_timur.required" => "wajib diisi",
				"ukuran_timur.integer" => "isikan hanya dengan bilangan bulat",
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

		$request['no_reg'] = VignereCip::decrypt($request['no_reg']);

		foreach ($request->all() as $key => $value) {
			$request[$key] = VignereCip::encrypt($value);
		}

		// var_dump($request->all());
		// die;

		try {
			$data = Spgr::findOrFail($id);
			$data->update($request->all());
			return response()->json(
				new APIResponse(
					true,
					"Data SPGR berhasil diperbaharui",
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
		$data = Spgr::findOrFail($id);

		if (!$user->can('delete spgr')) {
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
					"Data SPGR telah dihapus",
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
