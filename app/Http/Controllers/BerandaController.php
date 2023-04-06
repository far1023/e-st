<?php

namespace App\Http\Controllers;

use App\Models\PetaSituasiTanah;
use App\Models\Skt;
use App\Models\Spgr;
use App\Models\SuratSituasiTanah;

class BerandaController extends Controller
{
	public function index()
	{
		$data = [
			'all' => [
				'spgr' => Spgr::count(),
				'skt' => Skt::count(),
				'peta_situasi' => PetaSituasiTanah::count(),
				'surat_situasi' => SuratSituasiTanah::count(),
			],
			'need_approval' => [
				'spgr' => Spgr::where('approved_at', NULL)->count(),
				'skt' => Skt::where('approved_at', NULL)->count(),
				'peta_situasi' => PetaSituasiTanah::where('approved_at', NULL)->count(),
				'surat_situasi' => SuratSituasiTanah::where('approved_at', NULL)->count(),
			],
			"title" => "Beranda",
			"css"	=> [],
			"js"	=> NULL
		];

		return view('back/content/beranda', $data);
	}
}
