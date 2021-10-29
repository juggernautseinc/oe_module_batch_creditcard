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

require_once dirname(__FILE__, 5) . "/interface/globals.php";

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

    <style>
        body
        {
            margin: 0;
            padding: 0;
            background-color:#6abadeba;
            font-family: 'Arial';
        }
        .login{
            width: 382px;
            overflow: hidden;
            margin: auto;
            margin: 20 0 0 450px;
            padding: 80px;
            background: #23463f;
            border-radius: 15px ;
        }
        h2{
            text-align: center;
            color: #277582;
            padding: 20px;
        }
        label{
            color: #08ffd1;
            font-size: 17px;
        }
        #Uname{
            width: 300px;
            height: 30px;
            border: none;
            border-radius: 3px;
            padding-left: 8px;
        }
        #Pass{
            width: 300px;
            height: 30px;
            border: none;
            border-radius: 3px;
            padding-left: 8px;
        }
        #log{
            width: 300px;
            height: 30px;
            border: none;
            border-radius: 17px;
            padding-left: 7px;
            color: blue;
        }
        span{
            color: white;
            font-size: 17px;
        }
        a{
            float: right;
            background-color: grey;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login">
            <h1>Paytrace Login</h1>
            <form action="settings.php" method="post">
                <form id="login" method="get" action="login.php">
                    <label><b>User Name</b></label>
                    <input type="text" name="Uname" id="Uname" placeholder="Username">
                    <br><br>
                    <label><b>Password</b></label>
                    <input type="Password" name="Pass" id="Pass" placeholder="Password">
                    <br><br>
                    <input type="button" name="log" id="log" value="Log In Here">
                    <br><br>
                    <input type="checkbox" id="check">
                    <span>Remember me</span>
                    <br><br>
                    Forgot <a href="#">Password</a>
            </form>
        </div>
    </div><!-- end of container div -->
</body>
</html>
