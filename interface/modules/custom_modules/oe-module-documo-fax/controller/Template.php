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

class Template
{
    protected $file;
    protected $values = array();

    public function __construct($file)
    {
        $this->file = $file;
    }

    public function set($key, $value)
    {
        $this->values[$key] = $value;
    }

    public function output() {
        if (!file_exists($this->file)) {
            return "Error loading template file ($this->file).";
        }
        $output = file_get_contents($this->file);

        foreach ($this->values as $key => $value) {
            $tagToReplace = "[@$key]";
            $output = str_replace($tagToReplace, $value, $output);
        }

        return $output;
    }
}
