<?php

namespace App\Http\Controllers;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function responseSuccess($data, $message, $responseCode = Response::HTTP_OK, $statusCode = Response::HTTP_OK)
    {
        return api_response($data, $message, $responseCode, $statusCode);
    }

    public function responseError($data, $message, $responseCode, $statusCode)
    {
        return api_response($data, $message, $responseCode, $statusCode);
    }

}
