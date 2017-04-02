<?php

use Silex\Application;
use Entities\Country;
use PHPUnit\Framework\TestCase;

class ExportCSVFileTest extends TestCase
{

    private $app;

    public function setUp(){
        $this->app = require __DIR__.'/../src/app.php';
    }

    public function testCreateFile(){
        $countries = $this->app["orm.em"]->getRepository("Entities\Country")->findAll();
        $csv = new \Services\ExportCSVFile($countries, $this->app);
        $csv->createFile();

        $this->assertNotEmpty($csv->printOutput());

    }

}

?>