<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

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

$file = explode("/", $_GET['file']);

$que = dirname(__FILE__, 6) . "/sites/" . $_SESSION['site_id'] . "/documo/outbound/" . $file[2];

$dir = new SendFax();
$isDir = $dir::faxDir();
var_dump($isDir);

if ($_POST) {
    copy($_GET['file'], $que);
}

