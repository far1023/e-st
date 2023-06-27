<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratSituasiTanah extends Model
{
	use HasFactory;
	protected $guarded = [];
	protected $fillable = [];

	function scopeMirror()
	{
		return $this->join('mirrors', 'mirrors.id_on_refs', 'surat_situasi_tanahs.id')->where('mirrors.table_on_refs', 'surat_situasi_tanahs')->select('surat_situasi_tanahs.*', 'mirrors.data');
	}
}
