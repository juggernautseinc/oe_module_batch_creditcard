<?php

/*
 * package   OpenEMR
 *  link      http://www.open-emr.org
 *  author    Sherwin Gaddis <sherwingaddis@gmail.com>
 *  copyright Copyright (c )2022. Sherwin Gaddis <sherwingaddis@gmail.com>
 *  license   https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 *
 */

use OpenEMR\Modules\Documo\FaxApi;

require_once dirname(__FILE__,5) . "/globals.php";

//webhook
//inbound files from documo

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: multipart/form-data; charset-UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorizations, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

if ($uri[7] == 'inbound') {
    $inboundFaxFilesize = $_FILES['attachment']['size'];
    file_put_contents( "/var/www/html/errors/dir.txt", print_r(dirname(__FILE__, 6), true));
    //$inbound = dirname(__FILE__, 6) . "/sites/default/documents/documo/inbound/";
    $inbound = "/var/www/html/mindful_v63/sites/default/documents/documo/inbound/";
    move_uploaded_file($_FILES['attachment']['tmp_name'], $inbound . $_FILES['attachment']['name']);
    http_response_code(200);
}




