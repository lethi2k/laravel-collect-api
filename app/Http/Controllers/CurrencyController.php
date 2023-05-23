<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class CurrencyController extends BaseController
{
    public function index()
    {
        $host = "https://portal.vietcombank.com.vn/Usercontrols/TVPortal.TyGia/pXML.aspx";
        $json_string = $this->getSslPage($host);
        $result_array = json_decode($json_string, TRUE);
        foreach ($result_array['Exrate'] as $country_curency) {
            $list_curency[$country_curency['@attributes']['CurrencyCode']] = $country_curency['@attributes']['Sell'];
        }

        return $this->responseSuccess($list_curency, 'get data vietcommbank successfully!');
    }


    function getSslPage($url)
    {
        $ch = curl_init();
        $headr = array();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headr);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'spider');
        $data = curl_exec($ch);
        curl_close($ch);
        $xml = simplexml_load_string($data);
        return json_encode($xml);
    }
}
