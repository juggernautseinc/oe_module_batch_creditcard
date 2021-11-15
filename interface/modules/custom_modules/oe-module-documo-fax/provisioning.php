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
        .provision {
            box-shadow: 0px 10px 14px -7px #276873;
            background:linear-gradient(to bottom, #599bb3 5%, #408c99 100%);
            background-color:#599bb3;
            border-radius:8px;
            display:inline-block;
            cursor:pointer;
            color:#ffffff;
            font-family:Arial;
            font-size:20px;
            font-weight:bold;
            padding:13px 32px;
            text-decoration:none;
            text-shadow:0px 1px 0px #3d768a;
        }
        .provision:hover {
            background:linear-gradient(to bottom, #408c99 5%, #599bb3 100%);
            background-color:#408c99;
        }
        .provision:active {
            position:relative;
            top:1px;
        }
        .port {
            box-shadow: 0px 10px 14px -7px #fff6af;
            background:linear-gradient(to bottom, #ffec64 5%, #ffab23 100%);
            background-color:#ffec64;
            border-radius:8px;
            display:inline-block;
            cursor:pointer;
            color:#333333;
            font-family:Arial;
            font-size:20px;
            font-weight:bold;
            padding:13px 32px;
            text-decoration:none;
            text-shadow:0px 1px 0px #ffee66;
        }
        .port:hover {
            background:linear-gradient(to bottom, #ffab23 5%, #ffec64 100%);
            background-color:#ffab23;
        }
        .port:active {
            position:relative;
            top:1px;
        }
        .main {
            padding-top: 50px;
        }
    </style>
    <script>
        function toggleOrder(id) {

                document.getElementById(id).style.display = 'block';

                document.getElementById('transfer').style.display = 'none';
        }

        function toggleTransfer(id) {

                document.getElementById(id).style.display = 'block';

                document.getElementById('order').style.display = 'none';
        }
    </script>
</head>
<body>
    <div class="container-fluid main">
        <div class="buttons">
            <button id="provision" class="provision" onclick="toggleOrder('order')">Provision New Number</button>
            <button id="porting" class="port" onclick="toggleTransfer('transfer')">Port Current Number</button>
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

