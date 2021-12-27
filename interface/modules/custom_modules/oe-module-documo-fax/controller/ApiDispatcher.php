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
    public $faxNumber;
    public $attachment;
    public $subject;
    public $filePost;
    public $name;
    public $senderName;
    public $callerID;
    public $schedule;

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
        $postData = array("faxNumber"=>$this->faxNumber,"'attachments'"=>$this->filePost,"coverPage"=>'false',"coverPageId"=>'','tags'=>'','recipientName'=>$this->name,'senderName'=>$this->senderName,'subject'=>$this->subject,'callerId'=>$this->callerID,'notes'=>'','cf'=>'','scheduledDate'=>$this->schedule,'webhookId'=>'');
        $postData = str_replace(PHP_EOL, '', $postData);
        $postData = str_replace(' ', '', $postData);
        file_put_contents("/var/www/html/errors/postData.txt", print_r($postData,true));
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.documo.com/v1/faxes',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => str_replace(PHP_EOL, '',$postData),
            CURLOPT_HTTPHEADER => self::headerArray()
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
}
