<?php
/*
 * package   OpenEMR
 *  link      http://www.open-emr.org
 *  author    Sherwin Gaddis <sherwingaddis@gmail.com>
 *  copyright Copyright (c )2021. Sherwin Gaddis <sherwingaddis@gmail.com>
 *  license   https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 *
 */

namespace OpenEMR\Modules\Documo;

use Exception;
use http\Exception\UnexpectedValueException;

class SendFaxConfig
{
    private $uuid;
    const STATUS_WAITING = "waiting";
    const STATUS_PARAMETER_ERROR = 'parameter-error';
    const STATUS_UPLOAD_ERROR = 'fax upload error';
    const STATUS_IN_PROGRESS = 'in progress';
    const STATUS_SUCCESS = 'success';
    const SITE_ID = '/sites';

    const TABLE_NAME = 'documo_fax_log';

    public function __construct()
    {
        $getuuid = new Database();
        $this->uuid = $getuuid->getAccountId();
    }

    /**
     * @throws Exception
     */
    public static function faxDir(): string
    {
        $documo_path = dirname(__FILE__, 6) . self::SITE_ID . DIRECTORY_SEPARATOR . $_SESSION['site_id'] . "/documents/documo";
        $inbound_path = dirname(__FILE__, 6) . self::SITE_ID . DIRECTORY_SEPARATOR . $_SESSION['site_id'] . "/documents/documo/inbound";
        $outbound_path = dirname(__FILE__, 6) . self::SITE_ID . DIRECTORY_SEPARATOR . $_SESSION['site_id'] . "/documents/documo/outbound";

        if (!is_dir($documo_path)) {
            if (!mkdir($documo_path)) {
                $mkdirErrorArray = error_get_last();
                throw new UnexpectedValueException('cannot create director ' . $mkdirErrorArray['message']);
            }
            mkdir($inbound_path);
            mkdir($outbound_path);
            $response = "Created";
        } else {
            $response = "Found";
        }
        return $response;
    }

    public function createWebHookURI()
    {
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
            $http = "https://";
        } else {
            $http = "http://";
        }

        //if there is no webhook create one
        //webhooks are not needed to send a fax but used to get the status update so says tech support
        //That was incorrect also. Webhooks are for
        //leaving and skipping forward for now will return later
        if (empty($documohook['webhook'])) {
            $hookstring = 'name=oe-fax-module
        &url=' . $hookurl . 'webhook
        &events=%7B%20%22fax.inbound%22%3A%20true%2C%20%22fax.outbound%22%3A%20true%2C%20%22fax.outbound.extended%22%3A%20true%2C%20%22user.create%22%3A%20true%2C%20%22user.delete%22%3A%20true%2C%20%22number.add%22%3A%20false%2C%20%22number.release%22%3A%20false%2C%20%22document.complete%22%3A%20false%2C%20%22document.failed%22%3A%20false%20%7D
        &auth='.'
        &accountId=' . $user["account_id"] . '
        &numberId=' . $number_uuid[0]['uuid'] . '
        &attachmentEnabled=false
        &notificationEmails=' . $user["email"] . "'";
            $hookstring = str_replace(PHP_EOL, '', $hookstring); //remove returns
            $hookstring = str_replace(' ', '', $hookstring); //remove white spaces
            $response = $status->setWebHook($hookstring);
            $iint = is_int($response);
            if ($iint === false && !empty($response)) {
                //$hook->saveWebHook($response);
            } else {
                echo $response;
                die('Unable to get webhook, contact support: support@affordablecustomehr.com');
            }
        }

        return $http . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    }
}
