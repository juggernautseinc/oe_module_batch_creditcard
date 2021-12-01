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
use OpenEMR\Common\Twig\TwigContainer;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use OpenEMR\Core\Kernel;

require_once dirname(__FILE__, 5) . "/globals.php";
require_once dirname(__FILE__, 2) . "/controller/Database.php";

$header = Header::setupHeader(['common']);
$path = dirname(__FILE__) . "/templates";
$kernel = new Kernel();
$twigloader = new TwigContainer($path, $kernel);
$twig = $twigloader->getTwig();
$twig->addExtension(new Twig_Extension_Debug());

try {
    print $twig->render('account.twig', [
        'pageTitle' => 'Account Information',
        'header' => $header

    ]);
} catch (LoaderError | RuntimeError | SyntaxError $e) {
    print $e->getMessage();
}
