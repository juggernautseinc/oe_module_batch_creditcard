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

$dbcall = new Database();
$localtz = $dbcall->getTimeZone();
$hastable = $dbcall->tableCheck();
$hasAccount = $dbcall->hasSavedAccount();
$hasUser = $dbcall->hasUserAccount();
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
            let href = "<?php echo $GLOBALS['web_root'] ?>/interface/modules/custom_modules/oe-module-documo-fax/account/create/create.php?type=" + encodeURIComponent(type);
            dlgopen(href, '', 1175, 700, false, '', {
                buttons: [
                    {text: <?php echo xlj('Close'); ?>, close: true, style: 'default btn-sm'}
                ],
                onClosed: 'reload'
            });
        }
    </script>
    <style>
        .account {
            padding-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container account">
        <?php
            if (empty($localtz['gl_value'])) {
                echo "<h1>Time zone is not set, Please set time zone.</h1>";
                die;
             } elseif (!$hastable) {
                echo "<h3>Database tables not installed</h3>";
                die;
            }
            ?>
        <div>
            <h1>Welcome to the Documo Module</h1>
            <?php if(!$hasAccount) { ?>
                <p>There are two steps to complete to enable this module</p>
            <?php }
            if ($hasUser) {?>
                <p>There is one more step to complete!</p>
            <?php } ?>
        </div>
        <?php if(!$hasAccount) { ?>
        <div>
            <p>Step 1</p>
            <button class="btn btn-primary" onclick="createAccount('account')">Create an account</button>
        </div>
        <?php } else {?>
            <div >
                <p>Your fax account is active. </p>
            </div>
        <?php } ?>
        <?php if ($hasUser) { ?>
        <div>
            <p>Step 2</p>
            <button class="btn btn-primary" onclick="createAccount('user')">Create a user</button>
        </div>
        <?php }  echo $hasAccount . " " . $hasUser?>
        <?php if (!$hasAccount && $hasUser) { ?>
        <div>
            <h3>Account info</h3>
        </div>
        <?php } ?>
    </div>
</body>
</html>




