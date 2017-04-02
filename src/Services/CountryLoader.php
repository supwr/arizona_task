<?php

namespace Services;

use \Entities\Country;

class CountryLoader
{
    private $em;
    private $country;
    private $dataSource;

    public function __construct(Country $country, \Doctrine\ORM\EntityManager $em, $dataSource)
    {
        $this->country = $country;
        $this->em = $em;
        $this->dataSource = $dataSource;
    }

    public function loadCountriesToDatabase(){

        $file = new \SplFileObject($this->dataSource);
        $line = 0;
        $startLine = 3; //índice da linha onde inicia a lista de paises no documento

        while (!$file->eof()) {

            $code = "";
            $name = "";
            $spaceFound = false; // variavel usada para separar o pais do código
            $c = $file->current();

            if($line >= $startLine) {

                for ($i = 0; $i < strlen($c); $i++) {

                    if (strlen(trim($c[$i])) == 0) {
                        $spaceFound = true;
                    }

                    if (!$spaceFound) {
                        $code .= $c[$i];
                    } else {
                        $name .= $c[$i];
                    }

                }

                $country = new Country();
                $country->setName($name);
                $country->setCode($code);

                $this->em->persist($country);
            }

            $line++;
            $file->next();
        }

        $this->em->flush();
        $this->em->clear();

        $file = null;
    }


}

?>