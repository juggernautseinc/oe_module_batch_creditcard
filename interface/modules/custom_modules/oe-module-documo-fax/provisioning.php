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
use GuzzleHttp\Client;

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
    <style>
        #order {
            display: none;
        }
        #transfer {
            display: none;
        }
        #areacode {
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
            padding: 50px;
        }
        .form-group label {
            width: 100%;
            display: block;
            margin: 0;
            font-size: 1rem;
            letter-spacing: .1px;
            text-align: left;
            font-weight: 500;
            line-height: 2.5;
        }
        .ng-input {
            position: absolute;
            left: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container-fluid main">
        <div class="buttons">
            <button id="provision" class="provision" onclick="toggleOrder('order')"><?php echo xlt("Provision New Number") ?></button>
            <button id="porting" class="port" onclick="toggleTransfer('transfer')"><?php echo xlt("Port Current Number") ?></button>
        </div>
        <div id="order" class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-6">
                        <label ><?php echo xlt("Provision Type") ?></label>
                        <div role="combobox" class="ng-input" aria-expanded="false">
                            <select class="ng-input" id="provisiontype" name="provisiontype">
                                <option value="order"><?php echo xlt("Order") ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-6">
                        <lable><?php echo xlt("Search Type") ?></lable>
                        <div role="combobox" class="ng-input" aria-expanded="false">
                            <select class="ng-input" id="searchtype" name="searchtype">
                                <option><?php echo xlt("Select") ?></option>
                                <option value="prefix"><?php echo xlt("Prefix") ?></option>
                                <option value="tollfree"><?php echo xlt("Toll-free") ?></option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="transfer">
            <p><?php echo xlt("Port number") ?></p>
        </div>
        <div class="form-group col-6" id="areacode">
            <label><?php echo xlt("Area/Exchange Code") ?></label>
            <input id="prefix" class="ng-input" type="text" value="" placeholder="801 <?php echo xla(" Enter area / exchange code here"); ?>">
            <br><br>
                <input class="btn btn-primary" id="checkfornumbers" type="submit" value="<?php echo xlt("Get Available Numbers") ?>">
        </div>
        <div class="form-group col-16" id="numberdisplay">
            <!-- placeholder for the returned values -->
        </div>
    </div>
<script>
    document.getElementById('searchtype').addEventListener("change", numberType);
    function numberType() {
        const type = document.getElementById('searchtype').value;
        if (type === 'prefix') {
            document.getElementById("areacode").style.display = 'block';
        }
    }
    document.getElementById('checkfornumbers').addEventListener("click", numberSearch);
    function numberSearch() {
        const prefix = document.getElementById('prefix').value;
        alert('Do number search via ajax ' . prefix);
    }
</script>
</body>
</html>

