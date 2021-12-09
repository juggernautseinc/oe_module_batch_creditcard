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
use OpenEMR\Modules\Documo\ApiDispatcher;
use OpenEMR\Modules\Documo\Database;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

require_once dirname(__FILE__, 5) . "/globals.php";
die('here');
$path = dirname(__FILE__, 2) . "/templates";
$twigloader = new TwigContainer($path, $GLOBALS['kernel']);
$status = new ApiDispatcher();
$twig = $twigloader->getTwig();
$twig->addExtension(new Twig_Extension_Debug());

try {
    print $twig->render('account.twig', [
        'pageTitle' => 'Fax Que',
        'header' => Header::setupHeader(['common'])
    ]);
} catch (LoaderError | RuntimeError | SyntaxError $e) {
    print $e->getMessage();
}
