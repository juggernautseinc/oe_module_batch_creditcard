<?php
/*
 * package   OpenEMR
 *  link      http://www.open-emr.org
 *  author    Sherwin Gaddis <sherwingaddis@gmail.com>
 *  copyright Copyright (c )2022. Sherwin Gaddis <sherwingaddis@gmail.com>
 *  license   https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 *
 */

namespace OpenEMR\Modules\Documo;

class WebHookProcessor
{
    private $file;

    public function __construct($inbound)
    {
        $d = date("Y-m-d");
        $s = date('H:i:s');
        $queInboundFile = $d . "_" . $s . "_" . "inbound";
        $this->file = dirname(__FILE__, 5) . "/sites/" . $_SESSION['site_id'] . "/documents/documo/outbound/" . $queInboundFile;
        file_put_contents($this->file, $inbound);
    }

    public function isFileSaved()
    {
        if (file_exists($this->file)) {
            $x = 200;
        } else {
            $x = 400;
        }
        return $x;
    }

}
