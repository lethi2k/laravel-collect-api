<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BitkubController extends BaseController
{
    public function index(Request $request)
    {
        $client = new \GuzzleHttp\Client();
        try {
            $request = $client->request('GET', 'https://api.bitkub.com/api/market/trades?sym='.$request->sym.'&lmt=10');
        }catch (\Exception $e) {
           return $this->responseError($e, 'Get Bitkub exchange rate failed!');
        }
        $response = $request->getBody()->getContents();
        return $this->responseSuccess(json_decode($response), 'Get Bitkub exchange rate successfully!');
    }
}
