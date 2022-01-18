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


//webhook
//inbound files from documo

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: multipart/form-data; charset-UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorizations, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

//file_put_contents("/var/www/html/errors/post.txt", print_r($_POST, true));
//file_put_contents("/var/www/html/errors/content.txt", print_r($_FILES, true));
//file_put_contents("/var/www/html/errors/uriarray.txt", print_r($uri, true));

$inboundFaxDocumentName = $_FILES['attachment']['name'];
$inboundFaxLocation = $_FILES['attachment']['tmp_name'];
$inboundFaxFilesize = $_FILES['attachment']['size'];

file_put_contents('/var/www/html/errors/location.txt', $inboundFaxLocation);
move_uploaded_file($_FILES['attachment']['tmp_name'], "/var/www/html/errors/" . $_FILES['attachment']['name']);

http_response_code(200);

die;

// Requests from the same server don't have a HTTP_ORIGIN header
if (!array_key_exists('HTTP_ORIGIN', $_SERVER)) {
    $_SERVER['HTTP_ORIGIN'] = $_SERVER['SERVER_NAME'];
}

try {
    $API = new FaxApi($_REQUEST['request'], $_SERVER['HTTP_ORIGIN']);
    echo $API->processAPI();
} catch (Exception $e) {
    echo json_encode(Array('error' => $e->getMessage()));
}
