<?php

/*
 * package   OpenEMR
 *  link      http://www.open-emr.org
 *  author    Sherwin Gaddis <sherwingaddis@gmail.com>
 *  copyright Copyright (c )2021. Sherwin Gaddis <sherwingaddis@gmail.com>
 *  license   https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 *
 */

use OpenEMR\Module\Documo\Database;
use OpenEMR\Common\Csrf\CsrfUtils;

require_once dirname(__FILE__, 6) . '/globals.php';
require_once dirname(__FILE__, 3) . '/controller/Database.php';

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
    //TODO make API call
    echo "<pre>";
    var_dump($data);
    $postfields = "
accountName=%7B%7B" . $date['accountname'] . "%7D%7D&
faxCallerId=%7B%7B" . $date['faxcallerid'] . "%7D%7D&
faxCsid=%7B%7B" . $date['faxcsid'] . "%7D%7D&
emailNotifySendOption=" . $date['emailnotifysendoption'] . "&
emailNotifyReceiveOption=" . $date['emailnotifyreceiveoption'] . "&
emailNotifySendIncAttachment=%7B%7" . $date['emailNotifySendIncAttachment'] . "%7D%7D&
emailNotifyReceiveIncAttachment=%7B%7" . $date['emailNotifyReceiveIncAttachment'] . "%7D%7D&
timezone=%7B%7B" . $date['accountname'] . "%7D%7D&
allowEmailToFax=%7B%7" . $date['allowemailtofax'] . "%7D%7D&
usersTokenLife=%7B%7B" . $date['usersTokenLife'] . "%7D%7D&
cf=%7B%7None%7D%7D"
;
var_dump($postfields);

}
