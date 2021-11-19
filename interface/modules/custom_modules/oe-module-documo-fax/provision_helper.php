<?php

/*
 * package   OpenEMR
 *  link      http://www.open-emr.org
 *  author    Sherwin Gaddis <sherwingaddis@gmail.com>
 *  copyright Copyright (c )2021. Sherwin Gaddis <sherwingaddis@gmail.com>
 *  license   https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 *
 */

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

use OpenEMR\Modules\Documo\Provisioning;

//use OpenEMR\Common\Csrf\CsrfUtils;

require_once dirname(__FILE__, 4) . "/globals.php";
require_once "controller/Provisioning.php";

//if (!CsrfUtils::verifyCsrfToken($_POST['csrf_token'])) {
   // CsrfUtils::csrfNotVerified();
//}


$getNumbers = new Provisioning();
$list = $getNumbers->areacode = 757; //$_POST['areacode'];

var_dump($list);
