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
use OpenEMR\Modules\Documo\SendFax;
use OpenEMR\Core\Header;

require_once dirname(__FILE__, 5) . "/globals.php";
require_once dirname(__FILE__, 2) . "/vendor/autoload.php";

$file = explode("/", $_GET['file']);
$d = date("Y-m-d");
$s = date('H:i:s');
$queFile = $d . "_" . $s . "_" . $file[2];
$que = dirname(__FILE__, 6) . "/sites/" . $_SESSION['site_id'] . "/documents/documo/outbound/" . $queFile;

$dir = new SendFax();
$destinations = new Database();
$isDir = $dir::faxDir();
$places = $destinations->getOrganizations();

if ($isDir != "Found") {
    echo xlt('Fax directories were not created. Check php error log to see what the issue is.');
    die;
}
if ($_POST) {
    copy($_GET['file'], $que);
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Que Fax Document</title>
    <?php Header::setupHeader(['common', 'select2']); ?>
    <script>
        $(function() {
            $(".select-dropdown").select2({
                theme: "bootstrap4",
                <?php require($GLOBALS['srcdir'] . '/js/xl/select2.js.php'); ?>
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <h2 class="mt-5 mb-5">Send Document to Fax Que</h2>
        <form action="faxque.php" method="post" >
            <select class="select2-dropdown">

                <?php
                    print "<option>" . xlt('Select Destination') . "</option>";
                    while ($row = sqlFetchArray($places)) {
                        print "<option value='" . $row['fax'] . "'>" . $row['specialty'] . " " . $row['organization'] . " " . $row['street'] . " " . $row['fax'] . "</option>";
                    }
                ?>
            </select>
            <input class="btn btn-primary" type="submit" value="Send">
        </form>
    </div>
</body>
</html>
