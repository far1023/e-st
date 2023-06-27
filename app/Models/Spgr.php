<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spgr extends Model
{
	use HasFactory;
	protected $guarded = [];
	protected $fillable = [];

	function scopeMirror()
	{
		return $this->join('mirrors', 'mirrors.id_on_refs', 'spgrs.id')->where('mirrors.table_on_refs', 'spgrs')->select('spgrs.*', 'mirrors.data');
	}
}
