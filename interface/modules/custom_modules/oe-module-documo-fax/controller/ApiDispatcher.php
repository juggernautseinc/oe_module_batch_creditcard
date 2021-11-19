<?php

/**
 * package   OpenEMR
 *  link      http://www.open-emr.org
 *  author    Sherwin Gaddis <sherwingaddis@gmail.com>
 *  copyright Copyright (c )2021. Sherwin Gaddis <sherwingaddis@gmail.com>
 *  license   https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 *
 */

namespace OpenEMR\Modules\Documo;


class ApiDispatcher
{
    private $apiKey;
    public $areacode;


    public function __construct()
    {
        $this->apiKey = self::findApiKey();
    }

    private function headerArray(): array
    {
        $value = 'Authorization: Basic ' . $this->apiKey;
        return array(
            $value,
            'Content-Type: application/x-www-form-urlencoded'
        );
    }
    //TODO consolidate these api calls if possible
    public function createUser($postData)
    {
        $curl = curl_init();
        $value = 'Authorization: Basic ' . $this->apiKey;
        $header = array(
            $value,
            'Content-Type: application/x-www-form-urlencoded'
        );
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.documo.com/v1/users',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_HTTPHEADER => self::headerArray(),
        ));

        $response = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
        curl_close($curl);
        if ($status === 200) {
            return $response;
        } else {
            return $status;
        }
    }

    public function createAccount($postfields)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.documo.com/v1/accounts',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $postfields,
            CURLOPT_HTTPHEADER => self::headerArray(),
        ));

        $response = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
        curl_close($curl);
        if ($status === 200) {
            return $response;
        } else {
            return $status;
        }
    }

    public function findAvailableFaxNumber($areacode)
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.documo.com/v1/numbers/provision/search',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_POSTFIELDS => 'nap='.$areacode,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => self::headerArray(),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        if ($status === 200) {
            return $response;
        } else {
            return $status;
        }
    }

    private function findApiKey()
    {
        $url = "https://api.affordablecustomehr.com/api.php?name=pen";
        $client = curl_init($url);
        curl_setopt($client,CURLOPT_RETURNTRANSFER,true);
        $response = curl_exec($client);

        $result = json_decode($response);
        return $result->data;
    }
}
