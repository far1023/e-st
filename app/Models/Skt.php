<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skt extends Model
{
	use HasFactory;
	protected $guarded = [];
	protected $fillable = [];

	function scopeMirror()
	{
		return $this->join('mirrors', 'mirrors.id_on_refs', 'skts.id')->where('mirrors.table_on_refs', 'skts')->select('skts.*', 'mirrors.data');
	}
}
