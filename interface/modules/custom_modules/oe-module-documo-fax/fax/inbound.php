<?php

/*
 * package   OpenEMR
 *  link      http://www.open-emr.org
 *  author    Sherwin Gaddis <sherwingaddis@gmail.com>
 *  copyright Copyright (c )2022. Sherwin Gaddis <sherwingaddis@gmail.com>
 *
 */

use OpenEMR\Modules\Documo\Database;

require_once dirname(__FILE__, 5) . "/globals.php";
require_once dirname(__FILE__, 2) . "/vendor/autoload.php";

$data = new Database();
$faxesFromWebHook = $data->getInboundFaxesLocal();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inbound Faxes</title>
</head>
<body>
    <div class="container">
        <div class="table">
            <table class="table  table-striped table-bordered">
                <caption>Display of received faxes in the last 30 days</caption>
                <tr>
                    <th scope="col">Date</th>
                    <th scope="col">Message ID</th>
                    <th scope="col">Fax Number</th>
                    <th scope="col">Page Count</th>
                    <th scope="col">File</th>
                </tr>
                    <?php
                    while ($iter = sqlFetchArray($faxesFromWebHook)) {
                            $message_info = json_decode($iter['message_json'], true);
                            echo "<tr></tr><td>" . $iter['date'] . "</td><td>" . $message_info['messageId'] .
                            "</td><td>" . $message_info['faxNumber'] . "</td><td>" . $message_info['pagesCount'] .
                            "</td><td>" . $iter['file_name'] . "</td></tr>";
                        }
                    ?>
            </table>
        </div>
    </div>
    <div class="footer">
        &copy;  <?php echo date ('Y') .  xlt(" Juggernaut Systems Express");  ?>
        ?>
    </div>
</body>
</html>

