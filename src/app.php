<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

use Silex\Application;
use Silex\Provider\AssetServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;
use Services\CountryLoader;
use Entities\Country;

$app = new Application();
$app->register(new ServiceControllerServiceProvider());
$app->register(new AssetServiceProvider());
$app->register(new TwigServiceProvider());
$app->register(new HttpFragmentServiceProvider());

ExceptionHandler::register();
ErrorHandler::register();

//$app->error(function (\Exception $e, $code) use ($app) {
//    return $app->json(array("message" => "Ops. Houve um erro na requisição."), 500);
//});


$app->register(new Silex\Provider\DoctrineServiceProvider, array(
    'db.options' => array(
        'dbname' => 'arizona',
        'user' => 'root',
        'password' => 'root',
        'host' => 'localhost',
        'port' => 3306,
        'charset' => 'utf8',
        'driver' => 'pdo_mysql'
    )
));

$app->register(new DoctrineOrmServiceProvider, array(
    'orm.em.options' => array(
        'mappings' => array(
            array(
                'type' => 'annotation',
                'namespace' => 'Entities',
                'path' => __DIR__.'/Entities',
            )
        )
    )
));

$app->register(new Silex\Provider\AssetServiceProvider(), array(
    'assets.version' => 'v6',
    'assets.named_packages' => array(
        'assets' => array('base_path' => '/web/assets'),
    ),
));

$app['country_loader.datasource'] = "https://gist.githubusercontent.com/ivanrosolen/f8e9e588adf0286e341407aca63b5230/raw/99e205ea104190c5e09935f06b19c30c4c0cf17e/country";
$app['country_loader.service'] = function ($app) {
    return new CountryLoader(new Country(),$app["orm.em"],$app['country_loader.datasource']);
};

$app['twig'] = $app->extend('twig', function ($twig, $app) {
    // add custom globals, filters, tags, ...

    return $twig;
});

return $app;
