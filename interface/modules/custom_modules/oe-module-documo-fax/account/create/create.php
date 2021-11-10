<?php

/*
 * package   OpenEMR
 *  link      http://www.open-emr.org
 *  author    Sherwin Gaddis <sherwingaddis@gmail.com>
 *  copyright Copyright (c )2021. Sherwin Gaddis <sherwingaddis@gmail.com>
 *  license   https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 *
 */

use OpenEMR\Module\Documo\ApiDispatcher;
use OpenEMR\Module\Documo\Database;
use OpenEMR\Common\Csrf\CsrfUtils;

require_once dirname(__FILE__, 6) . '/globals.php';
require_once dirname(__FILE__, 3) . '/controller/Database.php';
require_once dirname(__FILE__, 3) . '/controller/ApiDispatcher.php';

$form = $_GET['type'];

$data = $_POST;

$token = CsrfUtils::collectCsrfToken();

$timez = new Database();
$localtz = $timez->getTimeZone();


if ($form == 'account') {
    require_once "account_template.php";
} elseif ($form == 'user') {
    require_once "user_template.php";
}

if (!empty($data['accountname'])) {
    if (!CsrfUtils::verifyCsrfToken($data['csrf_token'])) {
        CsrfUtils::csrfNotVerified();
    }
    //make API call
    echo "<pre>";

    $postfields = "
accountName=" . $data['accountname'] . "&faxCallerId=" . $data['faxcallerid'] . "&faxCsid=" . $data['faxcsid'] . "&emailNotifySendOption=" . $data['emailnotifysendoption'] . "&emailNotifyReceiveOption=" . $data['emailnotifyreceiveoption'] . "&emailNotifySendIncAttachment=" . $data['emailNotifySendIncAttachment'] . "&emailNotifyReceiveIncAttachment=" . $data['emailNotifyReceiveIncAttachment'] . "&timezone=" . $data['accountname'] . "&allowEmailToFax=" . $data['allowemailtofax'] . "&usersTokenLife=" . $data['usersTokenLife'] . "&cf=None";

$documoaccountcreation = new ApiDispatcher();
$response = $documoaccountcreation->createAccount($postfields);

var_dump($response);

}
