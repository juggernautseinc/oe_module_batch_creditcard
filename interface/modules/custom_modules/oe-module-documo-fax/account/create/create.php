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
use OpenEMR\Module\Documo\Template;
use OpenEMR\Common\Csrf\CsrfUtils;

require_once dirname(__FILE__, 6) . '/globals.php';
require_once dirname(__FILE__, 3) . '/controller/Template.php';
require_once dirname(__FILE__, 3) . '/controller/Database.php';

$form = $_GET['type'];

$data = $_POST;

$profile = new Template('account.html');
$token = CsrfUtils::collectCsrfToken();

$timez = new Database();
$localtz = $timez->getTimeZone();
$profile->set("csrf_token", $token);
$profile->set("timezone", $localtz['gl_value']);

if ($form == 'account') {
    echo $profile->output();
} elseif ($form == 'user') {
    require_once "user.html";
}

if (!empty($data['accountname'])) {
    if (!CsrfUtils::verifyCsrfToken($data['csrf_token'])) {
        CsrfUtils::csrfNotVerified();
    }
    //TODO test form
    echo "<pre>";
    var_dump($data);
}
