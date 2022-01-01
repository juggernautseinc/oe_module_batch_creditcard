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
    public $accountId;
    public $areacode;
    public $attachment;
    public $callerID;
    public $direction;
    public $filePost;
    public $faxNumber;
    public $faxstatus;
    public $limit;
    public $name;
    public $offset;
    public $senderName;
    public $schedule;
    public $subject;
    public $useraccountid;
    const USER_KEY = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VySWQiOiIwN2YyZmRiZi1lYzQ0LTQ2ZTYtOTg2NS1iNmQ0ODAyZmYwNjkiLCJhY2NvdW50SWQiOiJlYjRkYWNjYy1mM2FiLTQwYWQtYTlmYi1mYzBiMDMwZTA1ZGMiLCJpYXQiOjE2NDA3MzM4NDV9.QuJQmbKsvG5f7Yazz0a4kekTbHOeeuLYLFuyM4MX5f0';

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

    public function createUser($postData)
    {
        $curl = curl_init();

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

    public function findAvailableFaxNumber($areacode, $state, $zip)
    {
        $curl = curl_init();
        $post = 'npa=' . $areacode . '&state=' . $state . '&zipcode=' . $zip;
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.documo.com/v1/numbers/provision/search?'.$post,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => self::headerArray(),
        ));

        $response = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
        curl_close($curl);
        if ($status !== 200) {

            if ($status === 400) {
                $response = xlt("Invalid Input");
            } elseif ($status === 401) {
                $response = xlt("Unauthorized - Key may be expired");
            } elseif ($status === 404) {
                $response = xlt("Not Found");
            }
        }
        return $response;
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

    public function registerSelectedNumbers($faxNumbersRequest)
    {
        $curl = curl_init();
        file_put_contents("/var/www/html/errors/numbersrequest.txt", $faxNumbersRequest);
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.documo.com/v1/numbers/provision',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $faxNumbersRequest,
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

    public function getNetworkStatus()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.documo.com/ping',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        if ($response === 'OK') {
            $response = true;
        } else {
            $response = false;
        }
        return $response;
    }

    public function sendFax()
    {
        $curl = curl_init();
        $postData = array("faxNumber"=>$this->faxNumber,"'attachments'"=>$this->filePost,"coverPage"=>'false',"coverPageId"=>'','tags'=>'','recipientName'=>$this->name,'senderName'=>$this->senderName,'subject'=>$this->subject,'callerId'=>$this->callerID,'notes'=>'','scheduledDate'=>$this->schedule);
        file_put_contents("/var/www/html/errors/npost.txt", print_r($postData, true), FILE_APPEND);
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.documo.com/v1/faxes',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => 0,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic ' . self::USER_KEY,
                'Content-Type: multipart/form-data'
            )
        ));

        return curl_exec($curl);
    }

    public function setWebHook($hookstring) : string
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.documo.com/webhooks',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $hookstring,
            CURLOPT_HTTPHEADER => self::headerArray(),
        ));

        $response = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
        curl_close($curl);
        if ($status === 200) {
            return $response;
        } else {
            return $response;
        }
    }

    public function getFaxHistory()
    {
        $curl = curl_init();
        $getData = 'accountId='. $this->useraccountid .
            '&offset=' . $this->offset .
            '&limit=' . $this->limit .
            '&direction=' . $this->direction .
            '&status=' . $this->faxstatus;

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.documo.com/v1/fax/history?' . $getData,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic ' . self::USER_KEY
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }
}
