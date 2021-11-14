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

$dbcall = new Database();
$localtz = $dbcall->getTimeZone();
$documoaccountcreation = new ApiDispatcher();

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
    $postfields = "accountName=" . $data['accountname'] . "&
    faxCallerId=" . $data['faxcallerid'] . "&
    faxCsid=" . $data['faxcsid'] . "&
    emailNotifySendOption=" . $data['emailnotifysendoption'] . "&
    emailNotifyReceiveOption=" . $data['emailnotifyreceiveoption'] . "&
    emailNotifySendIncAttachment=" . $data['emailNotifySendIncAttachment'] . "&
    emailNotifyReceiveIncAttachment=" . $data['emailNotifyReceiveIncAttachment'] . "&
    timezone=" . $data['timezone'] . "&
    allowEmailToFax=" . $data['allowemailtofax'] . "&
    usersTokenLife=" . $data['usersTokenLife'] . "&
    cf=";

    $response = $documoaccountcreation->createAccount($postfields);
    if (!is_int($response)) {
        $dbcall->saveAccount($response);
        print xlt("Your account was successfully created. Close this window, and select create user next.");
    } else {
        print xlt("An error has occurred") . $response;
    }
}

if (!empty($data['first_name']))
{
    if (!CsrfUtils::verifyCsrfToken($data['csrf_token'])) {
        CsrfUtils::csrfNotVerified();
    }
    $accountId = $dbcall->getAccountId();
    //var_dump($data);
    $postfields = "firstName=" .  $data['first_name']  .  "&lastName=" .  $data['last_name']  .  "&password=" .  $data['password']  .  "&email=" .  $data['your_email']  .  "&userRole=" .  $data['userrole']  .  "&phone=" .  $data['phone']  .  "&accountId=" . $accountId . "&jobPosition=" .  $data['jobposition']  .  "&drive=false&sign=false&fax=false";
    //var_dump($postfields);
    $response = $documoaccountcreation->createUser($postfields);
    if (!is_int($response)) {
        $dbcall->saveUser($response);
        print xlt("The user was successfully created. Close this window, and start faxing! ");
    } else {
        print xlt("An error has occurred") . $response;
    }
}
