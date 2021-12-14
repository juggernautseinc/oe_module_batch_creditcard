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
require_once dirname(__FILE__, 2) . "/vendor/autoload.php";

use Exception;

class SendFax
{
    private $uuid;
    const STATUS_WAITING = "waiting";
    const STATUS_PARAMETER_ERROR = 'parameter-error';
    const STATUS_UPLOAD_ERROR = 'fax upload error';
    const STATUS_IN_PROGRESS = 'in progress';
    const STATUS_SUCCESS = 'success';
    const SITE_ID = 'sites';

    const TABLE_NAME = 'documo_fax_log';

    public function __construct()
    {
        $getuuid = new Database();
        $this->uuid = $getuuid->getAccountId();
    }

    public static function faxDir(): string
    {
        $documo_path = $GLOBALS['webroot'] . self::SITE_ID . "/" . $_SESSION['site_id'] . "/documo";
        $inbound_path = $GLOBALS['webroot'] . self::SITE_ID . "/"  . $_SESSION['site_id'] . "/documo/inbound";
        $outbound_path = $GLOBALS['webroot'] . self::SITE_ID . "/" . $_SESSION['site_id'] . "/documo/outbound";

        if (!file_exists($documo_path)) {
            try {
                mkdir($documo_path, 0755);
                chown($documo_path, "www-data:www-data");
            } catch (Exception $e) {
                return  $e->getMessage();
            }
            $exits = $documo_path;
        }
        return $exits;
    }
}
