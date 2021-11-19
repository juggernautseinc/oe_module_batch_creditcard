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

require_once "ApiDispatcher.php";

class Provisioning
{
    private $dispatch;
    public $areacode;

    public function __construct()
    {
        $this->dispatch = new ApiDispatcher();
    }

    public function seekNumber()
    {
        $numbers = $this->dispatch->findAvailableFaxNumber($this->areacode);
        return $numbers;
    }
}
