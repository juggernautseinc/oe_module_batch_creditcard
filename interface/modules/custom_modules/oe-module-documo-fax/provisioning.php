<?php

/*
 * package   OpenEMR
 *  link      http://www.open-emr.org
 *  author    Sherwin Gaddis <sherwingaddis@gmail.com>
 *  copyright Copyright (c )2021. Sherwin Gaddis <sherwingaddis@gmail.com>
 *  license   https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 *
 */

use OpenEMR\Core\Header;

require_once dirname(__FILE__, 4) . "/globals.php";

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Provisioning Fax Number</title>
    <?php Header::setupHeader(['common'])?>
    <style>
        #order {
            display: none;
        }
        #transfer {
            display: none;
        }

    </style>
    <script>
        function toggleOrder(id) {
            alert('here');
            const state = document.getElementById(id).style.display;
            if (state === 'none') {
                document.getElementById(id).style.display = 'block';
            }
            const other = document.getElementById('transfer').style.display;
            if (other === 'block') {
                document.getElementById('transfer').style.display = 'none';
            }
        }

        function toggleTransfer(id) {
            alert('here');
            const state = document.getElementById(id).style.display;
            if (state === 'none') {
                document.getElementById(id).style.display = 'block';
            }
            const other = document.getElementById('order').style.display;
            if (other === 'block') {
                document.getElementById('order').style.display = 'none';
            }
        }
    </script>
</head>
<body>
    <div class="container-fluid">
        <div class="buttons">
            <button id="provision" onclick="toggleOrder('order')">Provision New Number</button>
            <button id="porting" onclick="toggleTransfer('transfer')">Port Current Number</button>
        </div>
        <div id="order">
            <p>Order a new number</p>
        </div>
        <div id="transfer">
            <p>Port number</p>
        </div>

    </div>
</body>
</html>

