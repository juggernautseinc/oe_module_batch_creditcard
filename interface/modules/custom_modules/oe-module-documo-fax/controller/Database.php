<?php

/**
 * package   OpenEMR
 *  link      http//www.open-emr.org
 *  author    Sherwin Gaddis <sherwingaddis@gmail.com>
 *  copyright Copyright (c )2021. Sherwin Gaddis <sherwingaddis@gmail.com>
 *
 */

namespace OpenEMR\Modules\Documo;

class Database
{
    public $key;
    const ALT_TABLE = 'ALTER TABLE';
    const PRIMARY_ID = 'ADD PRIMARY KEY(`id`)';
    const MODIFY = 'MODIFY';
    const INT_AUTO = 'INT AUTO_INCREMENT';

    //Inbound fax properties
    private $message_json;
    private $file_name;

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
    `id` INT NOT NULL PRIMARY KEY auto_increment,
    `account_user` TEXT NOT NULL,
    `fax_numbers` TEXT NULL,
    `webhook` TEXT NULL,
    `password` TEXT NULL
) ENGINE = InnoDB COMMENT = 'documo account users';
DB;

        $DBSQLACCOUNT = <<<'DB'
    CREATE TABLE `documo_account`
(
    `id` INT NOT NULL PRIMARY KEY auto_increment,
    `account_info` TEXT NOT NULL
) ENGINE = InnoDB COMMENT = 'documo account information';
DB;
        $DBSQLLOG = <<<'DB'
    CREATE TABLE `documo_fax_inbound`
(
    `id` INT NOT NULL PRIMARY KEY auto_increment,
    `date` DATETIME NOT NULL,
    `message_json` TEXT NOT NULL,
    `file_name` VARCHAR(50) NOT NULL
) ENGINE = InnoDB COMMENT = 'documo fax inbound';
DB;

        $db = $GLOBALS['dbase'];
        $exist = sqlQuery("SHOW TABLES FROM `$db` LIKE 'documo_user'");
        if (empty($exist)) {
            sqlQuery($DBSQLACCOUNT);
            sqlQuery($DBSQLUSER);
            sqlQuery($DBSQLLOG);

            sqlStatement("ALTER TABLE `globals` CHANGE `gl_value` `gl_value` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL");
        }
    }

    public function tableCheck()
    {
        $db = $GLOBALS['dbase'];
        $exist = sqlQuery("SHOW TABLES FROM `$db` LIKE 'documo_account'");
        if (empty($exist)) {
            $state = false;
        } else {
            $state = true;
        }
        return $state;
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
            $state = true;
        } else {
            $state = false;
        }
        return $state;
    }

    public function hasUserAccount()
    {
        $sql = "SELECT * FROM `documo_user`";
        $hasRow = sqlQuery($sql);
        if (!empty($hasRow)) {
            $state = true;
        } else {
            $state = false;
        }
        return $state;
    }

    private function getPrivateKey()
    {
        $gkey = 'unique_installation_id';
        $sql = "select gl_value from globals where gl_name = ?";
        $privateKey = sqlQuery($sql, [$gkey]);
        return $privateKey['gl_value'];
    }

    public function saveAccount($response)
    {
        $sql = "INSERT INTO `documo_account` (`id`, `account_info`) VALUES ('', ?)";
        sqlStatement($sql, [$response]);
    }

    public function saveUser($response)
    {
        $sql = "INSERT INTO `documo_user` SET `id` = '', `account_user` = ?";
        sqlStatement($sql, [$response]);
    }

    public function getAccountId()
    {
        $sql = "select account_info from documo_account";
        $account_number = sqlQuery($sql);
        $accid = json_decode($account_number['account_info'], true);
        return $accid['uuid'];
    }

    public function saveProvisionedNumbers($provision)
    {
        $sql = "UPDATE documo_user SET fax_numbers = ?";
        try {
            sqlInsert($sql, [$provision]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function hasNumbersProvisioned()
    {
        $sql = "select fax_numbers from documo_user";
        $provisioned = sqlQuery($sql);
        if (!empty($provisioned)) {
            $state = true;
        } else {
            $state = false;
        }
        return $state;
    }
    public function countryCode()
    {
        $sql = "select gl_value from globals where gl_name = 'phone_country_code'";
        return sqlQuery($sql);
    }
    public function getAllAccountInfo()
    {
        $sql = "select account_info from documo_account";
        $data = sqlQuery($sql);
        return json_decode($data['account_info'], true);
    }

    public function getUserInfo()
    {
        $sql = "select `account_user` from documo_user";
        $data = sqlQuery($sql);
        return json_decode($data['account_user'], true);
    }

    public function getFaxNumbers()
    {
        $sql = "select fax_numbers from documo_user";
        $data = sqlQuery($sql);
        return json_decode($data['fax_numbers'], true);
    }

    public function getOrganizations()
    {
        $sql = "select id, specialty, organization, street, fax from users WHERE specialty != '' ORDER BY specialty";
        return sqlStatement($sql);
    }

    public function saveWebHook($data)
    {
        $sql = "update documo_user set webhook = ?";
        try {
            sqlStatement($sql, [$data]);
        } catch (\Exception $e) {
            $msg = xl("Error saving webhook" );
            return $msg . ":" . $e->getMessage();
        }

    }

    public function getInboundFaxesLocal()
    {
        $todayDate = date("Y-m-d" . " 23:59:59");
        $thirtyDaysAgo = date("Y-m-d", strtotime('-30 days'));
        $sql = "select * from `documo_fax_inbound` where `date` <= ? AND `date` >= ? ORDER BY id DESC";
        return sqlStatement($sql, [$todayDate, $thirtyDaysAgo . " 00:00:00"]);
    }

    public function inboundFaxSave()
    {
        $sql = "INSERT INTO `documo_fax_inbound` (`id`, `date`, `message_json`, `file_name`) VALUES ('', ?, ?, ?)";
        $date = date('Y-m-d H:i:s');
        $bindings = array($date, $this->message_json, $this->file_name);
        sqlStatement($sql, $bindings);
    }

    /**
     * @param mixed $message_json
     */
    public function setMessageJson($message_json): void
    {
        $this->message_json = $message_json;
    }

    /**
     * @param mixed $file_name
     */
    public function setFileName($file_name): void
    {
        $this->file_name = $file_name;
    }

}
