<?php

/*
 * package   OpenEMR
 *  link      http://www.open-emr.org
 *  author    Sherwin Gaddis <sherwingaddis@gmail.com>
 *  copyright Copyright (c )2021. Sherwin Gaddis <sherwingaddis@gmail.com>
 *  license   https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 *
 */

use OpenEMR\Modules\Documo\Database;
use OpenEMR\Modules\Documo\Provisioning;
use OpenEMR\Common\Csrf\CsrfUtils;

require_once dirname(__FILE__, 4) . "/globals.php";
require_once "controller/Provisioning.php";
require_once "controller/Database.php";

if (!CsrfUtils::verifyCsrfToken($_POST['token'])) {
    CsrfUtils::csrfNotVerified();
}

$provision = new Provisioning();

//set order type
$provision->setType($_POST['type']);

//remove token & order type
array_shift($_POST);
array_shift($_POST);

//Need number count
$quantity = count($_POST);
$provision->setQuanity($quantity);

//convert list to a comma seperated string if more than one number is selected
$numbers_list = implode(", ", $_POST);

//set number values
$numbers_list =trim($numbers_list);  //trim white space from front of number(s)
$provision->setNumbers($numbers_list);

//set account ID after retrieving it from database
$accountdata = new Database();
$a = $accountdata->getAccountId();
$provision->setAccountId($a);

//make provision request to documo
$request = $provision->numberProvisioning();
echo $request;
if ($request !== 400) {
    //Save the returned JSON
    $finish = $accountdata->saveProvisionedNumbers($request);
    echo $finish;
} else {
    echo $request;
}
