<?php

/*
 * package   OpenEMR
 *  link      http://www.open-emr.org
 *  author    Sherwin Gaddis <sherwingaddis@gmail.com>
 *  copyright Copyright (c )2021. Sherwin Gaddis <sherwingaddis@gmail.com>
 *  license   https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 *
 */

use OpenEMR\Modules\Documo\ApiDispatcher;
use OpenEMR\Modules\Documo\Database;
use OpenEMR\Modules\Documo\SendFaxConfig;
use OpenEMR\Common\Csrf\CsrfUtils;
use OpenEMR\Common\Crypto\CryptoGen;

require_once dirname(__FILE__, 6) . '/globals.php';
require_once dirname(__FILE__, 3) . "/vendor/autoload.php";


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
    usersTokenLife=" . $data['usersTokenLife'] ;

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

    $postFields = "firstName=" .  $data['first_name']  .  "&lastName=" .  $data['last_name']  .  "&password=" .  $data['password']  .  "&email=" .  $data['your_email']  .  "&userRole=" .  $data['userrole']  .  "&phone=" .  $data['phone']  .  "&accountId=" . $accountId . "&jobPosition=" .  $data['jobposition']  .  "&drive=false&sign=false&fax=true";
    $postFields = str_replace(' ', '', $postFields); //removing any white space
    $response = $documoaccountcreation->createUser($postFields);
    $response = json_decode($response, true);

    if (!$response['error']) {
        $dbcall->saveUser($response);
        $encryptPassword = new CryptoGen();
        sqlStatementNoLog('UPDATE documo_user SET password = ? WHERE id = 1', [$encryptPassword->encryptStandard($data['password'])]);

        //set web hook for inbound faxes
        $setWebHook = new SendFaxConfig();
        //First get user account id
        $userData = $dbcall->getUserInfo()['account_id'];
        $setWebHook->setUserEmail($userData['email']);
        $setWebHook->setUserAccount($userData['account_id']);
        $setWebHook->setUserUuid($userData[0]['uuid']);
        print $setWebHook->createWebHookURI();

        print xlt("The user was successfully created. Close this window, and start faxing! ");
    } else {
        print xlt("An error has occurred ") . " <br><strong>" . $response['error']['name'] . " <br>" . $response['error']['message'] . "</strong>";
    }

}
