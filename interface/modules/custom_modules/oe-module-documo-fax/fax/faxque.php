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
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

require_once dirname(__FILE__, 5) . "/globals.php";
require_once dirname(__FILE__, 2) . "/vendor/autoload.php";


$path = dirname(__FILE__, 2) . "/templates";
$twigloader = new TwigContainer($path, $GLOBALS['kernel']);
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
    var_dump($_POST);
    die;

    try {
        print $twig->render('queingfile.twig', [
           'pageTitle' => 'Added Fax to Outbound Que'
        ]);
    } catch (LoaderError|RuntimeError|SyntaxError $e) {
        print $e->getMessage();
    }
}
