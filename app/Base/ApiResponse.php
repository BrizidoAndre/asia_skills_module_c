<?php

namespace App\Base;

use Illuminate\Http\Exceptions\HttpResponseException;

class ApiResponse
{
    /**
     * Return the default error response format
     * @param $status
     * @param $message
     * @return mixed
     */
    static public function errorResponse($status, $message): mixed
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => $message,
        ], $status));
    }

    /**
     * Throw personalized response message
     * @param $status
     * @param $message
     * @return mixed
     */
    static public function throwResponse($status, $message): mixed
    {
        throw new HttpResponseException(response()->json($message, $status));
    }

    /**
     * Return personalized message
     * @param $status
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    static public function response($status, $message): \Illuminate\Http\JsonResponse
    {
        return response()->json($message, $status);
    }

    /**
     * Return the default success response message
     * @param $status
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    static public function defaultResponse($status, $message): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $message
        ], $status);
    }
}
