<?php

namespace App\Http\Traits\Common;

trait HasResponseStructure
{

	public function getTokenResponse($grantType, $token)
	{
		return response()->json([
			'status_code' => 200,
			'token_type' => 'Bearer',
			'grant_type' => $grantType,
			'access_token' => $token,
		], 200);
	}
	
	public function getSuccessResponse($data, $statusCode)
	{
		return response()->json([
			'status' => 'success',
			'code' => $statusCode,
			'data' => $data
		], $statusCode);
	}

	public function getSuccessBag($message, $statusCode)
	{
		return response()->json([
			'data' => [
				'status' => 'success',
				'status_code' => $statusCode,
				'message' => $message
			]
		], $statusCode);
	}

	public function getErrorBag($status, $statusCode, $message)
	{
		return response()->json([
			'errors' => [
				'status' => $status,
				'status_code' => $statusCode,
				'message' => $message
			]
		], $statusCode);
	}
}