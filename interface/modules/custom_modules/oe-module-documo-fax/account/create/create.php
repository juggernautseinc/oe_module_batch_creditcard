<?php

/*
 * package   OpenEMR
 *  link      http://www.open-emr.org
 *  author    Sherwin Gaddis <sherwingaddis@gmail.com>
 *  copyright Copyright (c )2021. Sherwin Gaddis <sherwingaddis@gmail.com>
 *  license   https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 *
 */

use OpenEMR\Module\Documo\Template;
use OpenEMR\Common\Csrf\CsrfUtils;

require_once dirname(__FILE__, 6) . '/globals.php';


$form = $_GET['type'];
$data = $_POST;
$profile = new Template('account.html');
$token = CsrfUtils::collectCsrfToken();
$verify = CsrfUtils::verifyCsrfToken();

$profile->set("csrf_token", $token);
$provile->set("timezone", $GLOBALS['gbl_time_zone']);

if ($form == 'account') {
    //require_once "account.html";

} elseif ($form == 'user') {
    require_once "user.html";
}

if (!empty($data['accountname'])) {
    echo "<pre>";
    var_dump($data);
}
