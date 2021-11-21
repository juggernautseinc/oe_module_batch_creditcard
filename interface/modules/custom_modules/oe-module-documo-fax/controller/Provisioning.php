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
    private $city;
    private $zipcode;
    private $type;

    public function __construct()
    {
        $this->dispatch = new ApiDispatcher();
    }

    public function seekNumber()
    {
        if (isset($city) && isset($zip) && isset($code)) {
            return $this->dispatch->findAvailableFaxNumber($this->type, $this->areaCode, $this->city, $this->zipcode);
        }
    }

    public function setAreaCode($value) : string
    {
       return $this->areaCode = $value;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city): string
    {
        return $this->city = $city;
    }

    /**
     * @param mixed $zipcode
     */
    public function setZipcode($zipcode): int
    {
        return $this->zipcode = $zipcode;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): string
    {
        return $this->type = $type;
    }


}
