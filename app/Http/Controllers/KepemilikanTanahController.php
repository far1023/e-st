<?php

namespace App\Http\Controllers;

use VignereCip;
use Carbon\Carbon;
use App\Models\Skt;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Resources\APIResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class KepemilikanTanahController extends Controller
{
	public function index()
	{
		//
	}

	public function data()
	{
		return view('back.content.data.skt', [
			"title" => "Data SKT",
			"css"	=> ['datatable'],
			"js"	=> 'data/sktjs'
		]);
	}

	public function dttable()
	{
		$user = User::find(Auth::user()->id);
		$data = Skt::latest()->get()->toArray();

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
				return $data['tempat_lahir_pemilik'] . " / " . Carbon::parse($data['tanggal_lahir_pemilik'])->isoFormat('DD/MM/Y');
			})
			->addColumn('aksi', function ($data) use ($user) {
				if ($user) {
					$aksi = "";

					if ($user->can('edit skt')) {
						$aksi .= "<a href='" . url('formulir/kepemilikan-tanah/' . $data['id'] . '/edit') . "' class='btn btn-sm btn-secondary mb-1 mx-1 edit'>Edit</a>";
					}
					if ($user->can('delete skt')) {
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
			$data = Skt::find($id)->toArray();
			foreach ($data as $key => $value) {
				if (!is_int($value)) {
					$data[$key] = VignereCip::decrypt($value);
				}
			}

			// dd($data);

			return response()->json(
				new APIResponse(
					true,
					"Data SKT ditemukan",
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
		$kades = User::whereHas('roles', function ($query) {
			$query->where('name', 'kades');
		})->first();

		$data = [
			"kades" => ($kades) ? $kades->name : '',
		];

		return view('back.content.formulir.formskt', [
			"data" => $data,
			"title" => "Formulir SKT",
			"css"	=> ['stepper', 'datepicker'],
			"js"	=> 'formulir/sktjs'
		]);
	}

	public function store(Request $request)
	{
		$validator = Validator::make(
			$request->all(),
			[
				"nama_pemilik" => ["required"],
				"tempat_lahir_pemilik" => ["required"],
				"tanggal_lahir_pemilik" => ["required", "date"],
				"wn_pemilik" => ["required"],
				"ktp_pemilik" => ["required"],
				"alamat_pemilik" => ["required"],
				"jalan_gang" => ["required"],
				"rt" => ["required"],
				"rw" => ["required"],
				"dusun" => ["required"],
				"desa" => ["required"],
				"kecamatan" => ["required"],
				"kabupaten" => ["required"],
				"luas_tanah" => ["required", "integer"],
				"peroleh_dari" => ["required"],
				"tanggal_ref" => ["nullable", "date"],
				"batas_utara" => ["required"],
				"ukuran_utara" => ["required", "integer"],
				"batas_selatan" => ["required"],
				"ukuran_selatan" => ["required", "integer"],
				"batas_barat" => ["required"],
				"ukuran_barat" => ["required", "integer"],
				"batas_timur" => ["required"],
				"ukuran_timur" => ["required", "integer"],
				"jabatan_saksi_satu" => ["required_with:nama_saksi_satu"],
				"jabatan_saksi_dua" => ["required_with:nama_saksi_dua"],
				"jabatan_saksi_tiga" => ["required_with:nama_saksi_tiga"],
				"mengetahui" => ["required"],
			],
			[
				"tanggal_ref.date" => "format tanggal tidak cocok",
				"nama_pemilik.required" => "wajib diisi",
				"tempat_lahir_pemilik.required" => "wajib diisi",
				"tanggal_lahir_pemilik.required" => "wajib diisi",
				"tanggal_lahir_pemilik.date" => "format tanggal tidak cocok",
				"wn_pemilik.required" => "wajib diisi",
				"ktp_pemilik.required" => "wajib diisi",
				"alamat_pemilik.required" => "wajib diisi",
				"jalan_gang.required" => "wajib diisi",
				"rt.required" => "wajib diisi",
				"rw.required" => "wajib diisi",
				"dusun.required" => "wajib diisi",
				"desa.required" => "wajib diisi",
				"kecamatan.required" => "wajib diisi",
				"kabupaten.required" => "wajib diisi",
				"luas_tanah.required" => "wajib diisi",
				"luas_tanah.integer" => "isikan hanya dengan bilangan bulat",
				"peroleh_dari" => "wajib diisi",
				"tanggal_ref.date" => "format tanggal tidak cocok",
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
				"jabatan_saksi_satu.required_with" => "isikan jabatan saksi satu",
				"jabatan_saksi_dua.required_with" => "isikan jabatan saksi dua",
				"jabatan_saksi_tiga.required_with" => "isikan jabatan saksi tiga",
				"mengetahui.required" => "wajib diisi",
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

		// var_dump($request->all());
		// die;

		try {
			Skt::create($request->all());
			return response()->json(
				new APIResponse(
					true,
					"Data SKT berhasil disimpan",
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
		return view('back.content.formulir.formskt', [
			"title" => "Formulir SKT - Edit",
			"css"	=> ['stepper', 'datepicker'],
			"js"	=> 'formulir/editsktjs'
		]);
	}

	public function update(Request $request, int $id)
	{
		$validator = Validator::make(
			$request->all(),
			[
				"nama_pemilik" => ["required"],
				"tempat_lahir_pemilik" => ["required"],
				"tanggal_lahir_pemilik" => ["required", "date"],
				"wn_pemilik" => ["required"],
				"ktp_pemilik" => ["required"],
				"alamat_pemilik" => ["required"],
				"jalan_gang" => ["required"],
				"rt" => ["required"],
				"rw" => ["required"],
				"dusun" => ["required"],
				"desa" => ["required"],
				"kecamatan" => ["required"],
				"kabupaten" => ["required"],
				"luas_tanah" => ["required", "integer"],
				"peroleh_dari" => ["required"],
				"tanggal_ref" => ["nullable", "date"],
				"batas_utara" => ["required"],
				"ukuran_utara" => ["required", "integer"],
				"batas_selatan" => ["required"],
				"ukuran_selatan" => ["required", "integer"],
				"batas_barat" => ["required"],
				"ukuran_barat" => ["required", "integer"],
				"batas_timur" => ["required"],
				"ukuran_timur" => ["required", "integer"],
				"jabatan_saksi_satu" => ["required_with:nama_saksi_satu"],
				"jabatan_saksi_dua" => ["required_with:nama_saksi_dua"],
				"jabatan_saksi_tiga" => ["required_with:nama_saksi_tiga"],
				"mengetahui" => ["required"],
			],
			[
				"tanggal_ref.date" => "format tanggal tidak cocok",
				"nama_pemilik.required" => "wajib diisi",
				"tempat_lahir_pemilik.required" => "wajib diisi",
				"tanggal_lahir_pemilik.required" => "wajib diisi",
				"tanggal_lahir_pemilik.date" => "format tanggal tidak cocok",
				"wn_pemilik.required" => "wajib diisi",
				"ktp_pemilik.required" => "wajib diisi",
				"alamat_pemilik.required" => "wajib diisi",
				"jalan_gang.required" => "wajib diisi",
				"rt.required" => "wajib diisi",
				"rw.required" => "wajib diisi",
				"dusun.required" => "wajib diisi",
				"desa.required" => "wajib diisi",
				"kecamatan.required" => "wajib diisi",
				"kabupaten.required" => "wajib diisi",
				"luas_tanah.required" => "wajib diisi",
				"luas_tanah.integer" => "isikan hanya dengan bilangan bulat",
				"peroleh_dari" => "wajib diisi",
				"tanggal_ref.date" => "format tanggal tidak cocok",
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
				"jabatan_saksi_satu.required_with" => "isikan jabatan saksi satu",
				"jabatan_saksi_dua.required_with" => "isikan jabatan saksi dua",
				"jabatan_saksi_tiga.required_with" => "isikan jabatan saksi tiga",
				"mengetahui.required" => "wajib diisi",
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

		// var_dump($request->all());
		// die;

		try {
			$data = Skt::findOrFail($id);
			$data->update($request->all());
			return response()->json(
				new APIResponse(
					true,
					"Data SKT berhasil diperbaharui",
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
		$data = Skt::findOrFail($id);

		if (!$user->can('delete skt')) {
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
					"Data SKT telah dihapus",
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
