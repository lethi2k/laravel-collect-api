<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class BitkubController extends BaseController
{
    public function index()
    {
        $client = new \GuzzleHttp\Client();
        $request = $client->request('GET', 'https://api.bitkub.com/api/market/trades?sym=THB_USDT&lmt=10');
        $response = $request->getBody()->getContents();
        return $this->responseSuccess(json_decode($response), 'Get Bitkub exchange rate successfully!');
    }
}
