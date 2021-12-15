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
//require_once dirname(__FILE__, 2) . "/vendor/autoload.php";

use Exception;
use http\Exception\UnexpectedValueException;

class SendFax
{
    private $uuid;
    const STATUS_WAITING = "waiting";
    const STATUS_PARAMETER_ERROR = 'parameter-error';
    const STATUS_UPLOAD_ERROR = 'fax upload error';
    const STATUS_IN_PROGRESS = 'in progress';
    const STATUS_SUCCESS = 'success';
    const SITE_ID = '/sites';

    const TABLE_NAME = 'documo_fax_log';

    public function __construct()
    {
        $getuuid = new Database();
        $this->uuid = $getuuid->getAccountId();
    }

    /**
     * @throws Exception
     */
    public static function faxDir(): string
    {
        $documo_path = dirname(__FILE__, 6) . self::SITE_ID . DIRECTORY_SEPARATOR . $_SESSION['site_id'] . "/documents/documo";
        $inbound_path = dirname(__FILE__, 6) . self::SITE_ID . DIRECTORY_SEPARATOR  . $_SESSION['site_id'] . "/documents/documo/inbound";
        $outbound_path = dirname(__FILE__, 6) . self::SITE_ID . DIRECTORY_SEPARATOR . $_SESSION['site_id'] . "/documents/documo/outbound";

        if (!is_dir($documo_path)) {
                if (!mkdir($documo_path)) {
                    $mkdirErrorArray = error_get_last();
                    throw new UnexpectedValueException('cannot create director ' . $mkdirErrorArray['message']);
                }
                mkdir($inbound_path);
                mkdir($outbound_path);
                $response = "Created";
        } else {
            $response = "Found";
        }
        return $response;
    }
}
