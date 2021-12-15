<?php

/*
 * package   OpenEMR
 *  link      http://www.open-emr.org
 *  author    Sherwin Gaddis <sherwingaddis@gmail.com>
 *  copyright Copyright (c )2021. Sherwin Gaddis <sherwingaddis@gmail.com>
 *  license   https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 *
 */

use OpenEMR\Modules\Documo\SendFax;

require_once dirname(__FILE__, 5) . "/globals.php";
require_once dirname(__FILE__, 2) . "/vendor/autoload.php";

$file = explode("/", $_GET['file']);
$d = date("Y-m-d");
$s = date('H:i:s');
$queFile = $d . "_" . $s . "_" . $file[2];
$que = dirname(__FILE__, 6) . "/sites/" . $_SESSION['site_id'] . "/documents/documo/outbound/" . $queFile;

$dir = new SendFax();
$isDir = $dir::faxDir();
var_dump($isDir);

if ($_POST) {
    copy($_GET['file'], $que);
}

