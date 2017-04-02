<?php

namespace Services;

use Services\ExportCountries;

class ExportCSVFile extends ExportCountries
{

    public function __construct(array $countries, \Silex\Application $app)
    {
        $this->countries = $countries;
        $this->app = $app;
    }

    public function createFile()
    {

        $csvString = "";

        $stream = function() use ($csvString) {
            $handle = fopen('php://output', 'w');

            foreach ($this->countries as $country) {
                $csvString .= trim($country->getName()) . "," . trim($country->getCode()) . "\n";
            }

            fwrite($handle, $csvString);

            fclose($handle);
        };

        $this->output = $this->app->stream($stream, 200, array(
            'Content-Type' => 'text/csv',
            'Content-Description' => 'File Transfer',
            'Content-Disposition' => 'attachment; filename="countries.csv"',
            'Expires' => '0',
            'Cache-Control' => 'must-revalidate',
            'Pragma' => 'public',
        ));

    }

}

?>