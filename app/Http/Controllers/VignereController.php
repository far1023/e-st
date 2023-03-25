<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use VignereCip;
use App\Http\Resources\APIResponse;
use Illuminate\Support\Facades\Validator;

class VignereController extends Controller
{
	public function cipher(Request $request)
	{
		$validator = Validator::make(
			$request->all(),
			[
				'text' => ['required'],
				'key' => ['required', 'alpha:ascii'],
			],
			[
				'text.required' => ' Isikan teks',
				'key.alpha' => ' Isikan key hanya dengan alfabet',
				'key.required' => ' Isikan key',
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

		if ($request->method == 'Encrypt') {
			$result['cipher'] = VignereCip::encrypt($request->text, $request->key);
		} else {
			$result['cipher'] = VignereCip::decrypt($request->text, $request->key);
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
