<?php

/*
 * package   OpenEMR
 *  link      http://www.open-emr.org
 *  author    Sherwin Gaddis <sherwingaddis@gmail.com>
 *  copyright Copyright (c )2021. Sherwin Gaddis <sherwingaddis@gmail.com>
 *  license   https://github.com/openemr/openemr/blob/master/LICENSE GNU General Public License 3
 *
 */

namespace OpenEMR\Module\Documo;

use OpenEMR\Module\Documo\ApiDispatcher;

class Provisioning
{
    private $dispatch;

    public function __construct()
    {
        $this->dispatch = new ApiDispatcher();
    }
}
