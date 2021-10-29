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

require_once dirname(__FILE__, 5) . "/interface/globals.php";

use OpenEMR\Module\BatchCreditCard\Database;
use OpenEMR\Common\Acl\AclMain;

//install database tables that are needed
if (!AclMain::aclCheckCore('admin', 'manage_modules')) {
    echo xlt('Not Authorized');
    exit;
}


$install = new Database();

$install->loadAccountTable();

require_once "settings.php";

