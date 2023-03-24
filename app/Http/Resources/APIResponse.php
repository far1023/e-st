<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class APIResponse extends JsonResource
{
	//define properti
	public $status;
	public $message;

	public function __construct(bool $status, string $message, $resource = NULL)
	{
		$this->status  = $status;
		$this->message = $message;
		$this->resource = $resource;
	}

	public function toArray($request)
	{
		if ($this->resource) {
			if (!$this->status) {
				$name = 'error';
			} else {
				$name = 'data';
			}

			return [
				'ok'  => $this->status,
				'message' => $this->message,
				$name    => $this->resource
			];
		} else {
			return [
				'ok'  => $this->status,
				'message' => $this->message
			];
		}
	}
}
