<?php

/**
 *
 * @package      OpenEMR
 * @link               https://www.open-emr.org
 *
 * @author    Sherwin Gaddis <sherwingaddis@gmail.com>
 * @copyright Copyright (c) 2021 Sherwin Gaddis <sherwingaddis@gmail.com>
 * @license   https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 *
 */

echo "Settings Go Here on this page";

use OpenEMR\Core\Header;

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Batch Credit Card Settings</title>
    <?php Header::setupHeader() ?>
</head>
<body>
    <div class="container">
        <div>
            <form action="settings.php" method="post">
                <label for="user">Username</label>
                <input type="text" name="user" id="user" value="<?php  ?>" placeholder="Paytrace Username">
                <label for="password">Password</label>
                <input type="text" name="password" id="password" value="<?php ?>" placeholder="Password">
                <input type="submit" value="Submit">
            </form>
        </div>
    </div><!-- end of container div -->
</body>
</html>
