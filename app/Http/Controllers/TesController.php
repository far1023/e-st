<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use VignereCip;

class TesController extends Controller
{
	public function index()
	{
		echo $encrypt = VignereCip::encrypt(env('VIGNERE_KEY', 'mantul'), 'mantab betul');

		$decrypt = VignereCip::decrypt(env('VIGNERE_KEY', 'mantul'), $encrypt);
		echo "<pre>";
		print_r($decrypt);
		echo "</pre>";
	}
}
