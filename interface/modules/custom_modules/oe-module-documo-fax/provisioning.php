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
    <link rel="stylesheet" src="css/style.css">
    <style>
    </style>
    <script scr="js/javascript.js"> </script>
</head>
<body>
    <div class="container-fluid main">
        <div class="buttons">
            <button id="provision" class="provision" onclick="toggleOrder('order')">Provision New Number</button>
            <button id="porting" class="port" onclick="toggleTransfer('transfer')">Port Current Number</button>
        </div>
        <div id="order" class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-6">
                        <label >Provision Type</label>
                        <div role="combobox" class="ng-input" aria-expanded="false">
                            <select class="ng-input" id="provisiontype" name="provisiontype">
                                <option value="order">Order</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-6">
                        <lable>Search Type</lable>
                        <div role="combobox" class="ng-input" aria-expanded="false">
                            <select class="ng-input" id="searchtype" name="searchtype">
                                <option value="prefix">Prefix</option>
                                <option value="tollfree">Toll-free</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="transfer">
            <p>Port number</p>
        </div>

    </div>
</body>
</html>

