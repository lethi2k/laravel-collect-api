<?php

namespace App\Http\Controllers;

use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;
use Nesk\Rialto\Data\JsFunction;
use Nesk\Puphpeteer\Puppeteer;

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

    public function pnb()
    {
        $client = new Client(HttpClient::create(['timeout' => 60]));
        $crawler = $client->request('GET', 'https://www.pnb.com.ph/index.php/foreign-exchange-rates');
        $tableData = [];
        $crawler->filter('.main table')->each(function ($row) use (&$tableData) {
            $rowData = [];
            $row->filter('td')->each(function ($cell) use (&$rowData) {
                $rowData[] = $cell->text();
            });

            $tableData[] = $rowData;
        });

        $result = [];
        $count = count($tableData[0]);
        for ($i = 4; $i < $count; $i += 3) {
            $result[] = [
                'code' => $tableData[0][$i],
                'buy' => $tableData[0][$i + 1],
                'sell' => $tableData[0][$i + 2],
            ];
        }

        return response()->json($result);
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
