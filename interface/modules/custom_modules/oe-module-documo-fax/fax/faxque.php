<?php

/*
 * package   OpenEMR
 *  link      http://www.open-emr.org
 *  author    Sherwin Gaddis <sherwingaddis@gmail.com>
 *  copyright Copyright (c )2021. Sherwin Gaddis <sherwingaddis@gmail.com>
 *  license   https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 *
 */

use OpenEMR\Common\Twig\TwigContainer;
use OpenEMR\Modules\Documo\ApiDispatcher;
use OpenEMR\Common\Csrf\CsrfUtils;
use OpenEMR\Modules\Documo\Database;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

require_once dirname(__FILE__, 5) . "/globals.php";
require_once dirname(__FILE__, 2) . "/vendor/autoload.php";


$path = dirname(__FILE__, 2) . "/templates";
$twigloader = new TwigContainer($path, $GLOBALS['kernel']);
$status = '';
try {
    $status = new ApiDispatcher();
} catch (Error $e) {
    print $e->getMessage();
}

$twig = $twigloader->getTwig();
$twig->addExtension(new Twig_Extension_Debug());

if (!$_POST['number']) {
    try {
        print $twig->render('que.twig', [
            'pageTitle' => 'Fax Que'

        ]);
    } catch (LoaderError|RuntimeError|SyntaxError $e) {
        print $e->getMessage();
    }
} else {
    if (!CsrfUtils::verifyCsrfToken($_POST["csrf_token"])) {
        CsrfUtils::csrfNotVerified();
    }
    $hook = new Database();
    $number_uuid = $hook->getFaxNumbers();
    $user = $hook->getUserInfo();
    $facility = $hook->getAllAccountInfo();

    //this url will change based on where I put the call to the hook function
    $hookurl = substr(getWebHookURI(), 0, -10);

    $documohook = $hook->getWebHook(); //This is to get the webhook UUID

    //if there is no webhook create one
    //webhooks are not needed to send a fax but used to get the status update so says tech support
    //leaving and skipping forward for now will return later
    if (empty($documohook['webhook'])) {
        $hookstring = 'name=oe-fax-module
        &url=' . $hookurl . 'webhook
        &events=%7B%20%22fax.inbound%22%3A%20true%2C%20%22fax.outbound%22%3A%20true%2C%20%22fax.outbound.extended%22%3A%20true%2C%20%22user.create%22%3A%20true%2C%20%22user.delete%22%3A%20true%2C%20%22number.add%22%3A%20false%2C%20%22number.release%22%3A%20false%2C%20%22document.complete%22%3A%20false%2C%20%22document.failed%22%3A%20false%20%7D
        &auth='.'
        &accountId=' . $hook->getAccountId() . '
        &numberId=' . $number_uuid[0]['uuid'] . '
        &attachmentEnabled=false
        &notificationEmails=' . $user["email"] . "'";
        $hookstring = str_replace(PHP_EOL, '', $hookstring); //remove returns
        $hookstring = str_replace(' ', '', $hookstring); //remove white spaces
        //$response = $status->setWebHook($hookstring);
        $iint = is_int($response);
        if ($iint === false && !empty($response)) {
            //$hook->saveWebHook($response);
        } else {
            echo $response;
            die('Unable to get webhook, contact support: support@affordablecustomehr.com');
        }
    }
    //$the_hook = $hook->getWebHook();
    $name = '';
    $the_number = explode("@", $_POST['number']);
    $scheduled = date('Y-m-d') . 'T' . date('H:i:s') . '.000Z';
    if ($the_number[0]) {
        $fax_number = $the_number[0];
    }
    if ($_POST['faxnumber']) {
        $fax_number = $_POST['faxnumber'];
    }
    if ($the_number[1]) {
        $name = $the_number[1];
    }
    if ($_POST['name'] && $name) {
        $name = $the_number[1] . " Attn: " . filter_input( INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    }
    //need country code
    $status->faxNumber = trim($hook->countryCode()['gl_value'] . str_replace('-', '', $fax_number));
    $status->filePost = new CURLFILE($_POST['file']);
    $status->name = $name;
    $status->senderName = $facility['accountName'];
    $status->subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_SPECIAL_CHARS);
    $status->callerID = $facility['faxCallerId'];
    $status->schedule = $scheduled;

    $sent = $status->sendFax();

    if (is_int($sent)) {
        $result = 'Please check fax number is valid and try again';
    } elseif ($sent['uuid']) {
        $result = 'Fax Successfully Queued for transmission, Check status in the Fax Manager page';
    }

    try {
        print $twig->render('results.twig', [
           'pageTitle' => 'Fax Sent Status',
            'result' => $result
        ]);
    } catch (LoaderError|RuntimeError|SyntaxError $e) {
        print $e->getMessage();
    }
    unlink($_POST['file']);
}
