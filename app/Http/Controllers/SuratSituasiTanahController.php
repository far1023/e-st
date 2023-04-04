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
			"css"	=> ['datatable', 'sweet-alert'],
			"js"	=> 'data/suratSituasiJs'
		]);
	}

	public function printSheet(int $id)
	{
		if ($surat_situasi = SuratSituasiTanah::find($id)->toArray()) {
			foreach ($surat_situasi as $key => $value) {
				if (!is_int($value)) {
					$surat_situasi[$key] = VignereCip::decrypt($value);
				}
			}
		} else {
			$surat_situasi = [];
		}

		$data = [
			'result' => $surat_situasi,
			'signed_url' => url('data/surat-situasi-tanah/' . $id . '/print-out')
		];

		return view('back.content.printSheet', [
			"data" => $data,
			"title" => "Surat Situasi Tanah",
			"css"	=> [],
			"js"	=> 'printSheetJs'
		]);
	}

	public function printOut(int $id)
	{
		if ($data = SuratSituasiTanah::find($id)->toArray()) {
			foreach ($data as $key => $value) {
				if (!is_int($value)) {
					$data[$key] = VignereCip::decrypt($value);
				}
			}
		} else {
			$data = [];
		}

		return view('back.content.printOut.suratSituasi', [
			"data" => $data,
			"title" => "Surat Situasi Tanah",
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
				if ($user) {
					$aksi = "<div class='text-right'>";

					if ($user->can('approve spgr')) {
						if (($user->hasRole('sekdes') && !$data['checked_at']) || ($user->hasRole('kades') && !$data['approved_at'] && $data['checked_at'])) {
							$aksi .= "<a href='javascript:void(0)' data-id='" . $data['id'] . "' class='btn btn-sm btn-success mb-1 mr-1 approve' title='Verifikasi permohonan'>Verifikasi</a>";
						} else if ($user->hasRole('superadmin') && !$data['checked_at']) {
							$aksi .= "<a href='javascript:void(0)' data-id='" . $data['id'] . "' class='btn btn-sm btn-success mb-1 mr-1 approve' title='Verifikasi permohonan'>Verifikasi</a>";
						}
					}
					if (($data['checked_at'] && $data['approved_at'])) {
						if ($user->can('print-out')) {
							$aksi .= "<a href='javascript:void(0)' data-url='" . url('data/surat-situasi-tanah/' . $data['id'] . '/print-out') . "' class='btn btn-sm btn-success mb-1 mr-1 cetak' title='Cetak surat'>Cetak</a>";
						}
					} else {
						if ($user->can('edit spgr')) {
							$aksi .= "<a href='" . url('formulir/surat-situasi-tanah/' . $data['id'] . '/edit') . "' class='btn btn-sm btn-secondary mb-1 mr-1 edit' title='Edit data'>Edit</a>";
						}
					}
					$aksi .= "<a href='" . url('data/surat-situasi-tanah/' . $data['id'] . '/cek') . "' class='btn btn-sm btn-primary mb-1' title='Lihat surat'>Cek</a>";
					if ($user->can('delete spgr')) {
						$aksi .= " <a href='javascript:void(0)' data-id='" . $data['id'] . "' class='btn btn-sm btn-danger mb-1 hapus' title='Hapus data'><i class=' las la-times'></i></a>";
					}

					return $aksi .= "</div>";
				}

				return NULL;
			})
			->addColumn('status', function ($data) {
				$status = '';

				if ($data['approved_at']) {
					$status .= '<span class="text-success">DISETUJUI</span>';
				} else if ($data['checked_at'] && !$data['approved_at']) {
					$status .= '<span class="text-dark">MENUNGGU PERSETUJUAN - KADES</span>';
				} else {
					$status .= '<span class="text-dark">MENUNGGU PERSETUJUAN - SEKDES</span>';
				}

				return $status;
			})
			->rawColumns(['status', 'aksi'])
			->addIndexColumn()
			->toJson();
	}

	public function show(int $id)
	{
		try {
			$data = SuratSituasiTanah::findOrFail($id)->toArray();
			foreach ($data as $key => $value) {
				if (!is_int($value)) {
					$data[$key] = VignereCip::decrypt($value);
				}
			}

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
			"title" => "Formulir Surat Situasi Tanah",
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
				"dusun" => ["required"],
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
				"dusun.required" => "wajib diisi",
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
			if ($key != 'sketsa') {
				$request[$key] = VignereCip::encrypt($value);
			}
		}

		$data = [
			"jalan_gang" => $request['jalan_gang'],
			"rt" => $request["rt"],
			"rw" => $request["rw"],
			"desa" => $request["desa"],
			"dusun" => $request["dusun"],
			"kecamatan" => $request["kecamatan"],
			"kabupaten" => $request["kabupaten"],
			"luas_tanah" => $request["luas_tanah"],
			"atas_nama" => $request["atas_nama"],
			"nama_saksi_satu" => $request["nama_saksi_satu"],
			"jabatan_saksi_satu" => $request["jabatan_saksi_satu"],
			"nama_saksi_dua" => $request["nama_saksi_dua"],
			"jabatan_saksi_dua" => $request["jabatan_saksi_dua"],
			"nama_saksi_tiga" => $request["nama_saksi_tiga"],
			"jabatan_saksi_tiga" => $request["jabatan_saksi_tiga"],
		];

		if ($request->file()) {
			$fileName = time() . '_surat_situasi.' . $request->sketsa->extension();
			$filePath = $request->file('sketsa')->storeAs('images/sketsa', $fileName);

			$data['sketsa'] = VignereCip::encrypt($filePath);
		}

		try {
			SuratSituasiTanah::create($data);
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

			foreach ($request->all() as $key => $value) {
				if ($key != 'sketsa') {
					$request[$key] = VignereCip::encrypt($value);
				}
			}
		}

		$data = [
			"jalan_gang" => $request['jalan_gang'],
			"rt" => $request["rt"],
			"rw" => $request["rw"],
			"desa" => $request["desa"],
			"dusun" => $request["dusun"],
			"kecamatan" => $request["kecamatan"],
			"kabupaten" => $request["kabupaten"],
			"luas_tanah" => $request["luas_tanah"],
			"atas_nama" => $request["atas_nama"],
			"nama_saksi_satu" => $request["nama_saksi_satu"],
			"jabatan_saksi_satu" => $request["jabatan_saksi_satu"],
			"nama_saksi_dua" => $request["nama_saksi_dua"],
			"jabatan_saksi_dua" => $request["jabatan_saksi_dua"],
			"nama_saksi_tiga" => $request["nama_saksi_tiga"],
			"jabatan_saksi_tiga" => $request["jabatan_saksi_tiga"],
		];

		if ($request->file()) {
			$fileName = time() . '_surat_situasi.' . $request->sketsa->extension();
			$filePath = $request->file('sketsa')->storeAs('images/sketsa', $fileName);

			$data['sketsa'] = VignereCip::encrypt($filePath);
		}

		try {
			$data = SuratSituasiTanah::findOrFail($id);
			$data->update($data);
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

	public function approve(int $id)
	{
		$user = User::find(Auth::user()->id);

		if (!$user->can('approve surat-situasi')) {
			return response()->json(
				new APIResponse(
					false,
					"access to the requested resource is forbidden"
				),
				403
			);
		}

		if ($user->hasRole('kades')) {
			$data = [
				'approved_at' => date('Y-m-d')
			];
		} else {
			$data = [
				'checked_at' => date('Y-m-d')
			];
		}

		try {
			$surat_situasi = SuratSituasiTanah::findOrFail($id);
			$surat_situasi->update($data);
			return response()->json(
				new APIResponse(
					true,
					"Status Surat Situasi diperbaharui",
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
