<?php
/*
 *
 *  package   OpenEMR
 *  link      http://www.open-emr.org
 *  author    Sherwin Gaddis <sherwingaddis@gmail.com>
 *  copyright Copyright (c )2021. Sherwin Gaddis <sherwingaddis@gmail.com>
 *  license   https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 *
 */

namespace OpenEMR\Module\BatchCreditCard;

use OpenEMR\Common\Crypto;

class Database
{
    private $cryptoGen;

    public function __construct()
    {
        $this->cryptoGen = new Crypto\CryptoGen();
    }

    public function loadAccountTable()
    {
        $DBSQL = <<<'DB'
 CREATE TABLE IF NOT EXISTS `paytrace_account`
(
    `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `username` TEXT,
    `password` TEXT,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB COMMENT = 'Paytrace Account';
DB;
        $db = $GLOBALS['dbase'];
        $exist = sqlQuery("SHOW TABLES FROM `$db` LIKE 'paytrace_account'");
        if (empty($exist)) {
            sqlQuery($DBSQL);
            sqlQuery($DBSQL_SESSIONS);
        }
    }

}
