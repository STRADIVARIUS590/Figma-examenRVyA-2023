<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait JsonResponser 
{
	public function jsonResponse($message = null, $data = null, $code = Response::HTTP_OK, $errors = null)
	{
		return response()->json([
            'message' => $message,
            'data' => $data,
            'code' => $code,
            'errors' => $errors
        ], $code);
	}
}