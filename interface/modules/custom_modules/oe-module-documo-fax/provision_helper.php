<?php

/*
 * package   OpenEMR
 *  link      http://www.open-emr.org
 *  author    Sherwin Gaddis <sherwingaddis@gmail.com>
 *  copyright Copyright (c )2021. Sherwin Gaddis <sherwingaddis@gmail.com>
 *  license   https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 *
 */

use OpenEMR\Modules\Documo\Provisioning;

//use OpenEMR\Common\Csrf\CsrfUtils;

require_once dirname(__FILE__, 4) . "/globals.php";
require_once "controller/Provisioning.php";

//if (!CsrfUtils::verifyCsrfToken($_POST['csrf_token'])) {
   // CsrfUtils::csrfNotVerified();
//}


$getNumbers = new Provisioning();
$getNumbers->areaCode = 757; //$_POST['areacode'];
$list = $getNumbers->seekNumber();
echo $list;
