<?php
/*
 * package   OpenEMR
 *  link      http://www.open-emr.org
 *  author    Sherwin Gaddis <sherwingaddis@gmail.com>
 *  copyright Copyright (c )2021. Sherwin Gaddis <sherwingaddis@gmail.com>
 *  license   https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 *
 */

namespace OpenEMR\Modules\Documo;

class SendFax
{
    private $uuid;

    public function __construct()
    {
        $getuuid = new Database();
        $this->uuid = $getuuid->getAccountId();
    }

    public static function faxDir()
    {
        $filepath = $GLOBALS['webroot'] . "sites/" . $_SESSION['site_id'] . "/documents/fax";
        if (file_exists($filepath)) {
            $exits = "Path exists";
        } else {
            $exits = "Not there";
        }
        return $exits;
    }


}
