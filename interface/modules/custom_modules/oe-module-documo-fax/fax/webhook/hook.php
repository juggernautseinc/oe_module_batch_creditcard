<?php

/*
 * package   OpenEMR
 *  link      http://www.open-emr.org
 *  author    Sherwin Gaddis <sherwingaddis@gmail.com>
 *  copyright Copyright (c )2021. Sherwin Gaddis <sherwingaddis@gmail.com>
 *  license   https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 *
 */

require_once dirname(__FILE__, 6) . "/globals.php";
function getURI() {
    $http = '';
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        $http = "https://";
    } else {
        $http = "http://";
    }
    return $http.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
}

echo getURI();
