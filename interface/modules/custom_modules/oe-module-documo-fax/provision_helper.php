<?php

/*
 * package   OpenEMR
 *  link      http://www.open-emr.org
 *  author    Sherwin Gaddis <sherwingaddis@gmail.com>
 *  copyright Copyright (c )2021. Sherwin Gaddis <sherwingaddis@gmail.com>
 *  license   https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 *
 */

use OpenEMR\Module\Documo\Provisioning;
use OpenEMR\Common\Csrf\CsrfUtils;

require_once dirname(__FILE__, 4) . "/globals.php";

if (!CsrfUtils::verifyCsrfToken($_POST['csrf_token'])) {
    CsrfUtils::csrfNotVerified();
}


$getNumbers = new Provisioning();
$list = $getNumbers->areacode = 757; //$_POST['areacode'];
