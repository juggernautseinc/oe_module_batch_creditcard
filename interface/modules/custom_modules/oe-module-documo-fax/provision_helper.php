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

use OpenEMR\Common\Csrf\CsrfUtils;

require_once dirname(__FILE__, 4) . "/globals.php";
require_once "controller/Provisioning.php";

if (!CsrfUtils::verifyCsrfToken($_POST['token'])) {
    CsrfUtils::csrfNotVerified();
}

$getNumbers = new Provisioning();

if (empty($_POST['name'])) {
    $areacodevalue = filter_input(INPUT_POST, 'areacode', FILTER_VALIDATE_INT);
    $getNumbers->setAreaCode($areacodevalue);

    $state = filter_input(INPUT_POST, 'state', FILTER_SANITIZE_STRING);
    $getNumbers->setState($state);

    $zip = filter_input(INPUT_POST, 'zip', FILTER_VALIDATE_INT);
    $getNumbers->setZipcode($zip);

    $list = $getNumbers->seekNumber();
    //TODO might be able to do the translation here before sending back to the browser
    echo $list;
} else {
    //Do this
    var_dump($_POST);
    $numbers = implode($_POST);
    var_dump(array_shift($numbers));

}
