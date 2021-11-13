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

use OpenEMR\Core\Header;

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Welcome to the module</title>
        <?php echo Header::setupHeader(); ?>
        <style>
            .note {
                color: #942a25;
                font-size: medium;
            }
        </style>
    </head>
    <body>
        <div class="container-fluid">
            <div>
                <h1>Welcome</h1>
            </div>
            <div>
                <p>Our document workflow solutions make working with documents easy, more secure, and better for our planet.</p>
            </div>
            <div>
                <h2 class="font-weight-bold pb-4">Enterprise <span class="text-primary">cloud fax</span> for regulated industries</h2>
                <p class="pr-xl-9 font-size-md-font-weight-bold">The easiest way for both large and small businesses to achieve real digital transformation. Save time and money by eliminating hardware and outsourcing fax to the cloud. Easily integrate secure and reliable cloud fax into existing apps and workflows.</p>
            </div>
            <div>
                <p class="note">Use the Fax Module selection from the main menu to configure the settings.</p>
                <p>Log out and log back in to the program to see the new menu item.</p>
            </div>

        </div>
    </body>
</html>
