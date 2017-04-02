<?php

namespace Controllers;

use Entities\Country;
use Symfony\Component\HttpFoundation\Request;
use Silex\Application;
use Silex\Api\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Response;
use Services\ExportCSVFile;

class HomeController implements ControllerProviderInterface
{

    public function connect(Application $app)
    {

        $factory = $app["controllers_factory"];

        $factory->get("/", "Controllers\HomeController::index");
        $factory->get("/load_countries", "Controllers\HomeController::loadCountries");
        $factory->get("/download_csv", "Controllers\HomeController::loadCSV");

        return $factory;

    }

    public function index(Application $app)
    {

        $countries = $app['orm.em']->getRepository("Entities\Country")->findBy(array(),array("name" => "ASC"));

        return new Response($app['twig']->render('home/home.html.twig', array('countries' => $countries)));
    }

    public function loadCountries(Application $app)
    {
        $total = count($app['orm.em']->getRepository("Entities\Country")->findAll());

        if($total > 0){
            return $app->json(array("message" => "Essa tabela já se encontra populada."), 200);
        }

        try{
            $app['country_loader.service']->loadCountriesToDatabase();

            return $app->json(array("message" => "Tabela populada com sucesso."), 200);
        }catch(Exception $e){
            return $app->json(array("message" => "Ops. Houve um erro na requisição."), 500);
        }
    }

    public function loadCSV(Application $app)
    {
        $countries = $app['orm.em']->getRepository("Entities\Country")->findAll();
        $csv = new ExportCSVFile($countries,$app);
        $csv->createFile();

        return $csv->printOutput();
    }

}



?>