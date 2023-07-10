<?php

namespace App\Http\Controllers;

use Cipher;
use Carbon\Carbon;
use App\Models\Spgr;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Resources\APIResponse;
use App\Models\Mirror;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class GantiRugiController extends Controller
{
	private $cipher;

	public function __construct()
	{
		$this->cipher = new Cipher([0, 1, 1, 2]);
	}

	public function data()
	{
		return view('back.content.data.spgr', [
			"title" => "Data SPGR",
			"css"	=> ['datatable', 'sweet-alert'],
			"js"	=> 'data/spgrJs'
		]);
	}

	public function printSheet(int $id)
	{
		$data = [];

		if ($data = Spgr::mirror()->find($id)->toArray()) {
			$decode = json_decode($data['data'], true);
			foreach ($data as $col => $value) {
				if (!is_int($value) && !str_contains($col, 'ed_at') && $col != 'data') {
					$data[$col] = $this->cipher->decrypt($decode[$col]);
				}
			}
		}

		$res = [
			'result' => $data,
			'signed_url' => url('data/ganti-rugi/' . $id . '/print-out')
		];

		return view('back.content.printSheet', [
			"data" => $res,
			"title" => "Ganti Rugi",
			"css"	=> [],
			"js"	=> 'printSheetJs'
		]);
	}

	public function printOut(int $id)
	{
		if ($data = Spgr::mirror()->find($id)->toArray()) {
			$decode = json_decode($data['data'], true);
			foreach ($data as $col => $value) {
				if (!is_int($value) && !str_contains($col, 'ed_at') && $col != 'data') {
					$data[$col] = $this->cipher->decrypt($decode[$col]);
				}
			}
		} else {
			$data = [];
		}

		return view('back.content.printOut.spgr', [
			"data" => $data,
			"title" => "Ganti Rugi",
		]);
	}

	public function dttable()
	{
		$data = Spgr::mirror()->latest()->get()->toArray();

		foreach ($data as $i => $value) {
			$decode = json_decode($value['data'], true);
			foreach ($value as $col => $val) {
				if (!is_int($val) && !str_contains($col, 'ed_at') && $col != 'data' && $val) {
					$value[$col] = $this->cipher->decrypt($decode[$col]);
				}
			}
			$data[$i] = $value;
		}

		return DataTables::of($data)
			->addColumn('ttl', function ($data) {
				return $data['tempat_lahir_pihak_pertama'] . " / " . Carbon::parse($data['tanggal_lahir_pihak_pertama'])->isoFormat('DD/MM/Y');
			})
			->addColumn('aksi', function ($data) {
				if (Auth::user()) {
					$aksi = "<div class='text-right'>";

					if (Auth::user()->can('approve spgr')) {
						if ((Auth::user()->hasRole('sekdes') && !$data['checked_at']) || (Auth::user()->hasRole('kades') && !$data['approved_at'] && $data['checked_at'])) {
							$aksi .= "<a href='javascript:void(0)' data-id='" . $data['id'] . "' class='btn btn-sm btn-success mb-1 mr-1 approve' title='Verifikasi permohonan'>Verifikasi</a>";
						} else if (Auth::user()->hasRole('superadmin') && !$data['checked_at']) {
							$aksi .= "<a href='javascript:void(0)' data-id='" . $data['id'] . "' class='btn btn-sm btn-success mb-1 mr-1 approve' title='Verifikasi permohonan'>Verifikasi</a>";
						}
					}
					if (($data['checked_at'] && $data['approved_at'])) {
						if (Auth::user()->can('print-out')) {
							if (Auth::user()->can('print-out')) {
								$aksi .= "<a href='javascript:void(0)' data-url='" . url('data/ganti-rugi/' . $data['id'] . '/print-out') . "' class='btn btn-sm btn-success mb-1 mr-1 cetak' title='Cetak surat'>Cetak</a>";
							}
						}
					} else {
						if (Auth::user()->can('edit spgr')) {
							$aksi .= "<a href='" . url('formulir/ganti-rugi/' . $data['id'] . '/edit') . "' class='btn btn-sm btn-secondary mb-1 mr-1 edit' title='Edit data'>Edit</a>";
						}
					}
					$aksi .= "<a href='" . url('data/ganti-rugi/' . $data['id'] . '/cek') . "' class='btn btn-sm btn-primary mb-1' title='Lihat surat'>Cek</a>";
					if (Auth::user()->can('delete spgr')) {
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
			->rawColumns(['ttl', 'status', 'aksi'])
			->addIndexColumn()
			->toJson();
	}

	public function show(int $id)
	{
		$data = Spgr::mirror()->findOrFail($id)->toArray();

		try {
			$decode = json_decode($data['data'], true);
			foreach ($data as $col => $value) {
				if (!is_int($value) && !str_contains($col, 'ed_at') && $col != 'data') {
					$data[$col] = $this->cipher->decrypt($decode[$col]);
				}
			}

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
		if (!Auth::user()->can('add spgr')) {
			abort(403, 'Unauthorized action.');
		}

		$spgr = Spgr::mirror()->latest()->first();

		if ($spgr) {
			$mirror_data = json_decode($spgr->data, true);
			$no_reg = $this->cipher->decrypt($mirror_data['no_reg']);

			if (explode('/', $no_reg)[2] == date('Y')) {
				$no_reg = intval(strtok($no_reg, '/')) + 1;
				$no_reg = $no_reg . "/SPGR/" . date('Y');
			}
		} else {
			$no_reg = 1 . "/SPGR/" . date('Y');
		}

		$kades = User::whereHas('roles', function ($query) {
			$query->where('name', 'kades');
		})->first();

		$data = [
			"kades" => ($kades) ? $kades->name : '',
			"no_reg" => $no_reg
		];

		return view('back.content.formulir.formSpgr', [
			"data" => $data,
			"title" => "Formulir SPGR",
			"css"	=> ['stepper', 'datepicker'],
			"js"	=> 'formulir/addSpgrJs'
		]);
	}

	public function store(Request $request)
	{
		if (!Auth::user()->can('add spgr')) {
			return response()->json(
				new APIResponse(
					false,
					"access to the requested resource is forbidden"
				),
				403
			);
		}

		$request['besaran'] = str_replace(".", "", $request['besaran']);
		$no_reg_encrypted = $this->cipher->encrypt($request['no_reg']);
		$request['no_reg'] = $no_reg_encrypted['data'];

		$validator = Validator::make(
			$request->all(),
			[
				"no_reg" => ["required"],
				"tanggal_reg" => ["required", "date"],
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
				"pergunaan_tanah" => ["required"],
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
				"tanggal_reg.required" => "wajib diisi",
				"tanggal_reg.date" => "format tanggal tidak cocok",
				"tanggal_ref.date" => "format tanggal tidak cocok",
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
				"pergunaan_tanah.required" => "wajib diisi",
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

		$request['no_reg'] = $this->cipher->decrypt($no_reg_encrypted['dec']);

		$mirror_data = [];
		foreach ($request->all() as $key => $value) {
			$encrypted = $this->cipher->encrypt($value);
			$request[$key] = $encrypted["data"];
			$mirror_data[$key] = $encrypted["dec"];
		}

		try {
			$spgr = Spgr::create($request->all());

			$mirror['table_on_refs'] = "spgrs";
			$mirror['id_on_refs'] = $spgr->id;
			$mirror['data'] = json_encode($mirror_data);
			Mirror::create($mirror);

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

	public function edit()
	{
		if (!Auth::user()->can('edit spgr')) {
			abort(403, 'Unauthorized action.');
		}

		return view('back.content.formulir.formSpgr', [
			"data" => NULL,
			"title" => "Formulir SPGR - Edit",
			"css"	=> ['stepper', 'datepicker'],
			"js"	=> 'formulir/editSpgrJs'
		]);
	}

	public function update(Request $request, int $id)
	{
		if (!Auth::user()->can('edit spgr')) {
			return response()->json(
				new APIResponse(
					false,
					"access to the requested resource is forbidden"
				),
				403
			);
		}

		$request['besaran'] = str_replace(".", "", $request['besaran']);
		$no_reg_encrypted = $this->cipher->encrypt($request['no_reg']);
		$request['no_reg'] = $no_reg_encrypted['data'];

		$validator = Validator::make(
			$request->all(),
			[
				"no_reg" => ["required"],
				"tanggal_reg" => ["required", "date"],
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
				"pergunaan_tanah" => ["required"],
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
				"tanggal_reg.required" => "wajib diisi",
				"tanggal_reg.date" => "format tanggal tidak cocok",
				"tanggal_ref.date" => "format tanggal tidak cocok",
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
				"pergunaan_tanah.required" => "wajib diisi",
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

		$request['no_reg'] = $this->cipher->decrypt($no_reg_encrypted['dec']);

		$mirror = Mirror::where('table_on_refs', 'spgrs')->where('id_on_refs', $id)->first()->toArray();
		unset($mirror['created_at'], $mirror['updated_at']);
		$mirror_data = json_decode($mirror['data'], true);
		foreach ($request->all() as $key => $value) {
			$encrypted = $this->cipher->encrypt($value);
			$request[$key] = $encrypted["data"];
			$mirror_data[$key] = $encrypted["dec"];
		}

		try {
			$data = Spgr::findOrFail($id);
			$data->update($request->all());

			$mirror['table_on_refs'] = "spgrs";
			$mirror['id_on_refs'] = $id;
			$mirror['data'] = json_encode($mirror_data);
			Mirror::where('table_on_refs', 'spgrs')->where('id_on_refs', $id)->update($mirror);

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

	public function approve(int $id)
	{
		if (!Auth::user()->can('approve spgr')) {
			return response()->json(
				new APIResponse(
					false,
					"access to the requested resource is forbidden"
				),
				403
			);
		}

		if (Auth::user()->hasRole('kades')) {
			$data = [
				'approved_at' => date('Y-m-d')
			];
		} else {
			$data = [
				'checked_at' => date('Y-m-d')
			];
		}

		try {
			$spgr = Spgr::findOrFail($id);
			$spgr->update($data);
			return response()->json(
				new APIResponse(
					true,
					"Status SPGR diperbaharui",
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
		if (!Auth::user()->can('delete spgr')) {
			return response()->json(
				new APIResponse(
					false,
					"access to the requested resource is forbidden"
				),
				403
			);
		}

		$data = Spgr::findOrFail($id);

		try {
			$data->delete();
			Mirror::where('table_on_refs', 'spgrs')->where('id_on_refs', $id)->delete();

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
