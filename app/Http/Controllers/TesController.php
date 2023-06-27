<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cipher;
use App\Http\Resources\APIResponse;
use Illuminate\Support\Facades\Validator;

class TesController extends Controller
{
	public function cipher(Request $request)
	{
		$validator = Validator::make(
			$request->all(),
			[
				'text' => ['required'],
			],
			[
				'text.required' => ' Isikan teks',
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

		$cipher = new Cipher([0, 1, 1, 2]);

		if ($request->method == 'Encrypt') {
			$result['cipher'] = $cipher->encrypt($request->text);
		} else {
			$result['cipher'] = $cipher->decrypt($request->text);
		}

		return response()->json(
			new APIResponse(
				true,
				"this is your result",
				$result
			),
			200
		);
	}
}
