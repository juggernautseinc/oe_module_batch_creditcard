<?php

/**
 * package   OpenEMR
 *  link      http//www.open-emr.org
 *  author    Sherwin Gaddis <sherwingaddis@gmail.com>
 *  copyright Copyright (c )2021. Sherwin Gaddis <sherwingaddis@gmail.com>
 *  license   https//github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 *
 */

namespace OpenEMR\Modules\Documo;

class Database
{
    public $key;

    public function __construct()
    {
        $this->key = self::getPrivateKey();
    }

    public function createTables()
    {
        /**
         * Here we are storing the json array that is sent back
         */
        $DBSQLUSER = <<<'DB'
    CREATE TABLE `documo_user`
(
    `id` INT NOT NULL,
    `user` TEXT NOT NULL
) ENGINE = InnoDB COMMENT = 'documo account users';
DB;

        $DBSQLACCOUNT = <<<'DB'
    CREATE TABLE `documo_account`
(
    `id` INT NOT NULL,
    `account_info` TEXT NOT NULL
) ENGINE = InnoDB COMMENT = 'documo account information';
DB;

        /**
         * TODO question do we really need the auto increment on the table?
         */
        $db = $GLOBALS['dbase'];
        $exist = sqlQuery("SHOW TABLES FROM `$db` LIKE 'documo_user'");
        if (empty($exist)) {
            sqlQuery($DBSQLACCOUNT);
            sqlQuery($DBSQLUSER);
            sqlStatement("ALTER TABLE `" . add_escape_custom('documo_user') . "` ADD PRIMARY KEY(`id`)");
            sqlStatement("ALTER TABLE `" . add_escape_custom('documo_user') . "` MODIFY " . add_escape_custom('id') . " INT AUTO_INCREMENT");
            sqlStatement("ALTER TABLE `" . add_escape_custom('documo_account') . "` ADD PRIMARY KEY(`id`)");
            sqlStatement("ALTER TABLE `" . add_escape_custom('documo_account') . "` MODIFY " . add_escape_custom('id') . " INT AUTO_INCREMENT");
        }
    }

    public function tableCheck()
    {
        $db = $GLOBALS['dbase'];
        $exist = sqlQuery("SHOW TABLES FROM `$db` LIKE 'documo_account'");
        if (empty($exist)) {
            return false;
        } else {
            return true;
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

    public function hasSavedAccount()
    {
        $sql = "SELECT * FROM `documo_account`";
        $hasRow = sqlQuery($sql);
        if (!empty($hasRow)) {
            return true;
        } else {
            return false;
        }
    }

    public function hasUserAccount()
    {
        $sql = "SELECT * FROM `documo_user`";
        $hasRow = sqlQuery($sql);
        if (!empty($hasRow)) {
            return true;
        } else {
            return false;
        }
    }

    private function getPrivateKey()
    {
        $key = 'unique_installation_id';
        $sql = "select gl_value from globals where gl_name = ?";
        $privateKey = sqlQuery($sql, [$key]);
        return $privateKey['gl_value'];
    }

    public function saveAccount($response)
    {
        $sql = "INSERT INTO `documo_account` (`id`, `account_info`) VALUES ('', ?)";
        sqlStatement($sql, [$response]);
    }

    public function saveUser($response)
    {
        $sql = "INSERT INTO `documo_user` (`id`, `account_user`) VALUES ('', ?)";
        sqlStatement($sql, [$response]);
    }

    public function getAccountId()
    {
        $sql = "select account_info from documo_account where id = 1";
        $account_number = sqlQuery($sql);
        $accid = json_decode($account_number['account_info'], true);
        return $accid['uuid'];
    }
}
