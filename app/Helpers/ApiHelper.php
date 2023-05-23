<?php

function api_response($data, $message, $responseCode, $statusCode)
{
    return response()->json([
        'code' => $responseCode,
        'message' => $message,
        'data' => $data,
    ], $statusCode);
}