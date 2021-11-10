<?php

/**
 * package   OpenEMR
 *  link      http//www.open-emr.org
 *  author    Sherwin Gaddis <sherwingaddis@gmail.com>
 *  copyright Copyright (c )2021. Sherwin Gaddis <sherwingaddis@gmail.com>
 *  license   https//github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 *
 */

namespace OpenEMR\Module\Documo;

class Database
{
    public function __construct()
    {
    }

    public function createTables()
    {
        $DBSQLUSER = <<<'DB'
    CREATE TABLE `documo_user`
(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user` TEXT NOT NULL
) ENGINE = InnoDB COMMENT = 'documo account users';
DB;

        $DBSQLACCOUNT = <<<'DB'
    CREATE TABLE `documo_account`
(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `account_info` TEXT NOT NULL
) ENGINE = InnoDB COMMENT = 'documo account information';
DB;

        $db = $GLOBALS['dbase'];
        $exist = sqlQuery("SHOW TABLES FROM `$db` LIKE 'documo_account'");
        if (empty($exist)) {
            sqlQuery($DBSQLACCOUNT);
            sqlQuery($DBSQLUSER);
        }
    }

    public function getTimeZone()
    {
        $global_data_array = array(
            'gl_value' => 'gbl_time_zone'
        );
        $fields = array_keys($global_data_array);
        $values = array_values($global_data_array);
        $fieldslist = implode(',', ($fields));
        $qs = str_repeat('?', count($fields)-1);

        $sql = "select $fieldslist from globals where gl_name = ${qs}?";
        return sqlQuery($sql, $values);
    }

    public function getAccountId()
    {

    }
}
