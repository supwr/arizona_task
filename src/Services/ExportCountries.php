<?php

namespace Services;

use \Entities\Country;
use Silex\Application;


class ExportCountries
{
    protected $countries;
    protected $output;
    protected $app;

    public function printOutput(){
        return $this->output;
    }
}


?>