<?php

/*
 * package   OpenEMR
 *  link      http://www.open-emr.org
 *  author    Sherwin Gaddis <sherwingaddis@gmail.com>
 *  copyright Copyright (c )2022. Sherwin Gaddis <sherwingaddis@gmail.com>
 *  license   https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 *
 */

use OpenEMR\Modules\Documo\WebHookProcessor;

//webhook
//inbound files from documo

if ($json = json_decode(file_get_contents("php://input"), true)) {
    if($json("resultInfo") == "OK") {
        http_response_code(200);
    }
    if ($_FILES) {
        $inboundFax = new WebHookProcessor($_FILES);
    }
    echo $inboundFax->isFileSaved();
} elseif ($_POST) {
    $data = $_POST;
    $inboundFax = new WebHookProcessor($data);
    echo $inboundFax->isFileSaved();
} else {
    echo '{"error":{"name":"File Status","message":"No files were transmitted"}}';
}
