<?php

namespace App\Helpers;
use App\Helpers\HttpStatusCode;

class ApiResponse
{
    /**
     * Return response JSON successful
     *
     * @param mixed $data
     * @param string $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public static function success($data = null, $message = 'Request successful', $statusCode = HttpStatusCode::OK)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }

    /**
     * Return response JSON failed
     *
     * @param string $message
     * @param int $statusCode
     * @param array|null $errors
     * @return \Illuminate\Http\JsonResponse
     */
    public static function error($message = 'Request failed', $statusCode = HttpStatusCode::BAD_REQUEST, $errors = null)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'errors' => $errors
        ], $statusCode);
    }

    /**
     * Return response JSON without data
     *
     * @param string $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public static function message($message, $statusCode = HttpStatusCode::OK)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => null
        ], $statusCode);
    }
}
