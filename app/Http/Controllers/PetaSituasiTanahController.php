<?php

namespace App\Http\Controllers;

use Cipher;
use App\Models\User;
use App\Models\Mirror;
use Illuminate\Http\Request;
use App\Models\PetaSituasiTanah;
use Yajra\DataTables\DataTables;
use App\Http\Resources\APIResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PetaSituasiTanahController extends Controller
{
	private $cipher;

	public function __construct()
	{
		$this->cipher = new Cipher([0, 1, 1, 2]);
	}

	public function data()
	{
		return view('back.content.data.petaSituasi', [
			"title" => "Data Peta Situasi Tanah",
			"css"	=> ['datatable', 'sweet-alert'],
			"js"	=> 'data/petaSituasiJs'
		]);
	}

	public function printSheet(int $id)
	{
		$data = [];

		if ($data = PetaSituasiTanah::mirror()->find($id)->toArray()) {
			$decode = json_decode($data['data'], true);
			foreach ($data as $col => $value) {
				if (!is_int($value) && !str_contains($col, 'ed_at') && $col != 'data' && ($col != 'sketsa' || $data['sketsa'] != NULL)) {
					$data[$col] = $this->cipher->decrypt($decode[$col]);
				}
			}
		}

		$res = [
			'result' => $data,
			'signed_url' => url('data/peta-situasi-tanah/' . $id . '/print-out')
		];

		return view('back.content.printSheet', [
			"data" => $res,
			"title" => "Peta Situasi Tanah",
			"css"	=> [],
			"js"	=> 'printSheetJs'
		]);
	}

	public function printOut(int $id)
	{
		$data = [];

		if ($data = PetaSituasiTanah::mirror()->find($id)->toArray()) {
			$decode = json_decode($data['data'], true);
			foreach ($data as $col => $value) {
				if (!is_int($value) && !str_contains($col, 'ed_at') && $col != 'data' && ($col != 'sketsa' || $data['sketsa'] != NULL)) {
					$data[$col] = $this->cipher->decrypt($decode[$col]);
				}
			}
		}

		return view('back.content.printOut.petaSituasi', [
			"data" => $data,
			"title" => "Peta Situasi Tanah",
		]);
	}

	public function dttable()
	{
		$data = PetaSituasiTanah::mirror()->latest()->get()->toArray();

		foreach ($data as $i => $value) {
			$decode = json_decode($value['data'], true);
			foreach ($value as $col => $val) {
				if (!is_int($val) && !str_contains($col, 'ed_at') && $col != 'data' && ($col != 'sketsa' || $value['sketsa'] != NULL)) {
					$value[$col] = $this->cipher->decrypt($decode[$col]);
				}
			}
			$data[$i] = $value;
		}

		return DataTables::of($data)
			->addColumn('aksi', function ($data) {
				if (Auth::user()) {
					$aksi = "<div class='text-right'>";

					if (Auth::user()->can('approve peta-situasi')) {
						if ((Auth::user()->hasRole('sekdes') && !$data['checked_at']) || (Auth::user()->hasRole('kades') && !$data['approved_at'] && $data['checked_at'])) {
							$aksi .= "<a href='javascript:void(0)' data-id='" . $data['id'] . "' class='btn btn-sm btn-success mb-1 mr-1 approve' title='Verifikasi permohonan'>Verifikasi</a>";
						} else if (Auth::user()->hasRole('superadmin') && !$data['checked_at']) {
							$aksi .= "<a href='javascript:void(0)' data-id='" . $data['id'] . "' class='btn btn-sm btn-success mb-1 mr-1 approve' title='Verifikasi permohonan'>Verifikasi</a>";
						}
					}
					if (($data['checked_at'] && $data['approved_at'])) {
						if (Auth::user()->can('print-out')) {
							$aksi .= "<a href='javascript:void(0)' data-url='" . url('data/peta-situasi-tanah/' . $data['id'] . '/print-out') . "' class='btn btn-sm btn-success mb-1 mr-1 cetak' title='Cetak surat'>Cetak</a>";
						}
					} else {
						if (Auth::user()->can('edit peta-situasi')) {
							$aksi .= "<a href='" . url('formulir/peta-situasi-tanah/' . $data['id'] . '/edit') . "' class='btn btn-sm btn-secondary mb-1 mr-1 edit' title='Edit data'>Edit</a>";
						}
					}
					$aksi .= "<a href='" . url('data/peta-situasi-tanah/' . $data['id'] . '/cek') . "' class='btn btn-sm btn-primary mb-1' title='Lihat surat'>Cek</a>";
					if (Auth::user()->can('delete peta-situasi')) {
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
		$data = PetaSituasiTanah::mirror()->findOrFail($id)->toArray();

		try {
			$decode = json_decode($data['data'], true);
			foreach ($data as $col => $value) {
				if (!is_int($value) && !str_contains($col, 'ed_at') && $col != 'data' && ($col != 'sketsa' || $data['sketsa'] != NULL)) {
					$data[$col] = $this->cipher->decrypt($decode[$col]);
				}
			}

			return response()->json(
				new APIResponse(
					true,
					"Data Peta Situasi Tanah ditemukan",
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
		if (!Auth::user()->can('add peta-situasi')) {
			abort(403, 'Unauthorized action');
		}

		$kades = User::whereHas('roles', function ($query) {
			$query->where('name', 'kades');
		})->first();

		$data = [
			"kades" => ($kades) ? $kades->name : ''
		];

		return view('back.content.formulir.formPetaSituasi', [
			"data" => $data,
			"title" => "Formulir Peta Situasi Tanah",
			"css"	=> ['stepper', 'datepicker'],
			"js"	=> 'formulir/addPetaSituasiJs'
		]);
	}

	public function store(Request $request)
	{
		if (!Auth::user()->can('add peta-situasi')) {
			return response()->json(
				new APIResponse(
					false,
					"access to the requested resource is forbidden"
				),
				403
			);
		}

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
				"mengetahui" => ["required"],
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

		$mirror_data = [];
		foreach ($request->all() as $key => $value) {
			if ($key != 'sketsa') {
				$encrypted = $this->cipher->encrypt($value);
				$request[$key] = $encrypted["data"];
				$mirror_data[$key] = $encrypted["dec"];
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
			"mengetahui" => $request["mengetahui"],
		];

		if ($request->file()) {
			$fileName = time() . '_peta.' . $request->sketsa->extension();
			$filePath = $request->file('sketsa')->storeAs('images/sketsa', $fileName);

			$encrypted = $this->cipher->encrypt($filePath);
			$data['sketsa'] = $encrypted["data"];
			$mirror_data['sketsa'] = $encrypted["dec"];
		}

		try {
			$peta_situasi = PetaSituasiTanah::create($data);

			$mirror['table_on_refs'] = "peta_situasi_tanahs";
			$mirror['id_on_refs'] = $peta_situasi->id;
			$mirror['data'] = json_encode($mirror_data);
			Mirror::create($mirror);

			return response()->json(
				new APIResponse(
					true,
					"Data Peta Situasi Tanah berhasil disimpan",
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
		if (!Auth::user()->can('edit peta-situasi')) {
			abort(403, 'Unauthorized action');
		}

		return view('back.content.formulir.formPetaSituasi', [
			"data" => NULL,
			"title" => "Formulir Peta Situasi Tanah - Edit",
			"css"	=> ['stepper', 'datepicker'],
			"js"	=> 'formulir/editPetaSituasiJs'
		]);
	}

	public function update(Request $request, int $id)
	{
		if (!Auth::user()->can('edit peta-situasi')) {
			return response()->json(
				new APIResponse(
					false,
					"access to the requested resource is forbidden"
				),
				403
			);
		}

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
				"mengetahui" => ["required"],
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

		$mirror = Mirror::where('table_on_refs', 'peta_situasi_tanahs')->where('id_on_refs', $id)->first()->toArray();
		unset($mirror['created_at'], $mirror['updated_at']);
		$mirror_data = json_decode($mirror['data'], true);
		foreach ($request->all() as $key => $value) {
			if ($key != 'sketsa') {
				$encrypted = $this->cipher->encrypt($value);
				$request[$key] = $encrypted["data"];
				$mirror_data[$key] = $encrypted["dec"];
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
			"mengetahui" => $request["mengetahui"],
		];

		if ($request->file()) {
			$fileName = time() . '_peta.' . $request->sketsa->extension();
			$filePath = $request->file('sketsa')->storeAs('images/sketsa', $fileName);

			$encrypted = $this->cipher->encrypt($filePath);
			$data['sketsa'] = $encrypted["data"];
			$mirror_data['sketsa'] = $encrypted["dec"];
		}

		try {
			$data = PetaSituasiTanah::findOrFail($id);
			$data->update($request->all());

			$mirror['table_on_refs'] = "peta_situasi_tanahs";
			$mirror['id_on_refs'] = $id;
			$mirror['data'] = json_encode($mirror_data);
			Mirror::where('table_on_refs', 'peta_situasi_tanahs')->where('id_on_refs', $id)->update($mirror);

			return response()->json(
				new APIResponse(
					true,
					"Data Peta Situasi Tanah berhasil diperbaharui",
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
		if (!Auth::user()->can('approve peta-situasi')) {
			return response()->json(
				new APIResponse(
					false,
					"access to the requested resource is forbidden"
				),
				403
			);
		}

		if (!Auth::user()->hasRole('kades')) {
			$data = [
				'approved_at' => date('Y-m-d')
			];
		} else {
			$data = [
				'checked_at' => date('Y-m-d')
			];
		}

		try {
			$peta_situasi = PetaSituasiTanah::findOrFail($id);
			$peta_situasi->update($data);
			return response()->json(
				new APIResponse(
					true,
					"Status Peta Situasi diperbaharui",
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
		if (!Auth::user()->can('delete peta-situasi')) {
			return response()->json(
				new APIResponse(
					false,
					"access to the requested resource is forbidden"
				),
				403
			);
		}

		$data = PetaSituasiTanah::findOrFail($id);

		try {
			$data->delete();
			Mirror::where('table_on_refs', 'peta_situasi_tanahs')->where('id_on_refs', $id)->delete();

			return response()->json(
				new APIResponse(
					true,
					"Data Peta Situasi Tanah telah dihapus",
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
