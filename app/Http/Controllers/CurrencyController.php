<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class CurrencyController extends BaseController
{
    public function index()
    {
        $response = Http::get('https://portal.vietcombank.com.vn/Usercontrols/TVPortal.TyGia/pXML.aspx');

        return $this->responseSuccess($response, 'get data successfully!');
    }
}
