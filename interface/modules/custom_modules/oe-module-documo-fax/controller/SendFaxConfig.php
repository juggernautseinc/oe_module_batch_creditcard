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
    private $userAccount;
    private $userUuid;
    private $userEmail;


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

        if (!is_dir($documo_path)) {
            if (!mkdir($documo_path)) {
                $mkdirErrorArray = error_get_last();
                throw new UnexpectedValueException('cannot create director ' . $mkdirErrorArray['message']);
            }
            mkdir($inbound_path);
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
            echo xlt('You must have an SSL certificate to receive inbound faxes');
            die;
        }

        $hook = new Database();
        $hookUrl = $http . dirname(__FILE__, 6) . '/sites/' . $_SESSION['site_id'] .
        '/documents/documo/inbound/' . $_SESSION['site_id'] . '/';

        //remove any returns and spaces from the string
        $hookUrl = str_replace(PHP_EOL, '', $hookUrl);
        $hookUrl = str_replace(' ', '', $hookUrl);

        $hookString = 'name=oe-fax-module
        &url=' . $hookUrl .
        '&events=%7B%20%22fax.inbound%22%3A%20true%2C%20%22fax.outbound%22%3A%20true%2C%20%22fax.outbound.extended%22%3A%20false%2C%20%22user.create%22%3A%20true%2C%20%22user.delete%22%3A%20true%2C%20%22number.add%22%3A%20false%2C%20%22number.release%22%3A%20false%2C%20%22document.complete%22%3A%20false%2C%20%22document.failed%22%3A%20false%20%7D
        &auth='.'
        &accountId=' . $this->userAccount . '
        &numberId=' . $this->userUuid . '
        &attachmentEnabled=false
        &notificationEmails=' . $this->userEmail . "'";
        $hookString = str_replace(PHP_EOL, '', $hookString); //remove returns
        $hookString = str_replace(' ', '', $hookString); //remove white spaces
        $sendWebHook = new ApiDispatcher();
        $response = $sendWebHook->setWebHook($hookString);
        return $hook->saveWebHook($response);
    }

    /**
     * @param mixed $userAccount
     */
    public function setUserAccount($userAccount): void
    {
        $this->userAccount = $userAccount;
    }

    /**
     * @param mixed $userUuid
     */
    public function setUserUuid($userUuid): void
    {
        $this->userUuid = $userUuid;
    }

    /**
     * @param mixed $userEmail
     */
    public function setUserEmail($userEmail): void
    {
        $this->userEmail = $userEmail;
    }
}
