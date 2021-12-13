<?php

/*
 * package   OpenEMR
 *  link      http://www.open-emr.org
 *  author    Sherwin Gaddis <sherwingaddis@gmail.com>
 *  copyright Copyright (c )2021. Sherwin Gaddis <sherwingaddis@gmail.com>
 *  license   https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 *
 */


$file = explode("/", $_GET['file']);

var_dump($file);

$que = dirname(__FILE__, 6) . "/sites/" . $_SESSION['site_id'] . "/documo/outbound/";
var_dump($que);
copy($_GET['file'], $que . $file[2]);


