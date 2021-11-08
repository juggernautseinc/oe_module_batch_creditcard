<?php

/**
 * package   OpenEMR
 *  link      http://www.open-emr.org
 *  author    Sherwin Gaddis <sherwingaddis@gmail.com>
 *  copyright Copyright (c )2021. Sherwin Gaddis <sherwingaddis@gmail.com>
 *  license   https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 *
 */


require_once dirname(__FILE__, 4) . "/globals.php";
require_once dirname(__FILE__) . "/controller/Database.php";

use OpenEMR\Core\Header;
use OpenEMR\Module\Documo\Database;

$timez = new Database();
$localtz = $timez->getTimeZone();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Documo Setting Page</title>
    <?php echo Header::setupHeader(['common']) ?>
    <script>
        function createAccount(type) {
            let href = "<?php echo $GLOBALS['web_root'] ?>/interface/modules/custom_modules/oe-module-documo-fax/account/create/create.php?type=";
            dlgopen(href+type, '_blank', 1175, 700);
        }
    </script>
</head>
<body>
    <div class="container">
        <?php
            if (empty($localtz['gl_value'])) {
            echo "<h1>Time zone is not set, Please set time zone.</h1>";
            die;
        }?>
        <div>
            <h1>Welcome to the Documo Module</h1>
            <p>There are three steps to complete to enable this module</p>
        </div>
        <div>
            <p>Step 1</p>
            <btn class="btn btn-primary" onclick="createAccount('account')">Create an account</btn>
        </div>
        <div>
            <p>Step 2</p>
            <btn class="btn btn-primary" onclick="createAccount('user')">Create a user</btn>
        </div>
    </div>
</body>
</html>




