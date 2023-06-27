<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetaSituasiTanah extends Model
{
	use HasFactory;
	protected $guarded = [];
	protected $fillable = [];

	function scopeMirror()
	{
		return $this->join('mirrors', 'mirrors.id_on_refs', 'peta_situasi_tanahs.id')->where('mirrors.table_on_refs', 'peta_situasi_tanahs')->select('peta_situasi_tanahs.*', 'mirrors.data');
	}
}
