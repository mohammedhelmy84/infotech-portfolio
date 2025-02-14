<?php

namespace App\Helpers;

class Helpers
{
    /**
     * Return a standard JSON response.
     */
    public static function jsonResponse($success, $data = null, $message = null, $statusCode = 200)
    {
        // Structure the response data
        $response = [
            'success' => $success,
            'data' => $data,
            'message' => $message,
        ];

        // Filter out any null values from the response to keep it clean
        $response = array_filter($response, function($value) {
            return !is_null($value);
        });

        return response()->json($response, $statusCode);
    }
}
