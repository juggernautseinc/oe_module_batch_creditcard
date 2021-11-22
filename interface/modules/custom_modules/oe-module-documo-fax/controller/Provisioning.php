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
require_once "Database.php";

class Provisioning
{
    private $dispatch;
    private $areaCode;
    private $state;
    private $zipcode;

    public function __construct()
    {
        $this->dispatch = new ApiDispatcher();
    }

    public function seekNumber()
    {
        if (isset($this->areaCode)) {
            return $this->dispatch->findAvailableFaxNumber(
                $this->areaCode,
                $this->state,
                $this->zipcode
            );
        } else {
            return 'error';
        }
    }

    /**
     * @param $value
     * @return string
     */
    public function setAreaCode($value) : int
    {
       return $this->areaCode = $value;
    }

    /**
     * @param mixed $state
     */
    public function setState($state): string
    {
        return $this->state = $state;
    }

    /**
     * @param mixed $zipcode
     */
    public function setZipcode($zipcode): int
    {
        return $this->zipcode = $zipcode;
    }


}
