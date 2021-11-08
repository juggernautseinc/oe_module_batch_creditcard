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
        $DBSQLACCOUNT = <<<'DB'
 CREATE TABLE IF NOT EXISTS `documo_account`
(
  `uuid` varchar(50) NOT NULL,
  `accountname` varchar(50) NOT NULL,
  `accountnumber` int(30) NOT NULL,
  `accounttype` TEXT NOT NULL,
  `allowadmin` TEXT NOT NULL,
  `allowapi` TEXT NOT NULL,
  `allowenterprise` TEXT NOT NULL,
  `allow_admin_numbers_provision` TEXT NOT NULL,
  `allowadminnumbersreleasing` TEXT NOT NULL ,
  `allowemailtofax` TEXT NOT NULL,
  `allowfaxattachments` TEXT NOT NULL,
  `allownumbersforwarding` TEXT NOT NULL,
  `allownumbersmanaging` TEXT NOT NULL,
  `allownumbersporting` TEXT NOT NULL,
  `allowusersmanaging` TEXT NOT NULL,
  `timezone` TEXT NOT NULL,
  `emailnotifysendoption` TEXT NOT NULL,
  `emailnotifyreceiveoption` TEXT NOT NULL,
  `emailnotifysendincattachment` BOOL NOT NULL,
  `emailnotifyreceiveincattachment` BOOL NOT NULL,
  `emailnotifyemailtofaxqueued` BOOL NOT NULL,
  `faxcsid` TEXT NOT NULL,
  `faxcallerid` int NOT NULL,
  `faxdefaultcoverpage` TEXT NOT NULL,
  `faxLifetime` int NOT NULL,
  `parentid` varchar(50) NOT NULL,
  `portingnotificationemails` varchar(25) NOT NULL,
  `createdat` varchar(25) NOT NULL,
  `updatedat` varchar(25) NOT NULL,
  `childrencount` smallint NOT NULL,
  `userscount` int NOT NULL,
  `cf` TEXT NOT NULL
)
DB;

        $DBSQLUSER = <<<'DB'
    CREATE TABLE `documo_user`
(
    `firstName` TEXT NOT NULL,
    `lastName` TEXT NOT NULL,
    `email` TEXT NOT NULL,
    `userRole` TEXT NOT NULL,
    `password` TEXT NOT NULL,
    `phone` TEXT NOT NULL,
    `accountId` TEXT NOT NULL,
    `jobPosition` TEXT NOT NULL,
    `drive` smallint,
    `sign` smallint,
    `fax` smallint,
    `cf` TEXT NOT NULL
)
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


}
