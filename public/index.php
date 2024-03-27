<?php

declare(strict_types=1);

use App\Middelware\ApiKeyMiddelware;
use Slim\Factory\AppFactory;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use DI\Container;
use DI\ContainerBuilder;
use Slim\Handlers\Strategies\RequestResponseArgs;

define('APP_ROOT',dirname(__DIR__));

require  APP_ROOT. '/vendor/autoload.php';

$builder = new Containerbuilder();

$container = $builder->addDefinitions(APP_ROOT.'/config/definitions.php')
                        ->build();

AppFactory:: setContainer($container);

$app = AppFactory::create();

$collector = $app->getRouteCollector();
$collector->setDefaultInvocationStrategy(new RequestResponseArgs);

$error_middelware = $app->addErrorMiddleware(true, true, true);
$error_handler = $error_middelware->getDefaultErrorHandler();
$error_handler->forceContentType('application/json');

$app->add(new ApiKeyMiddelware);

$app->addBodyParsingMiddleware();


$app->get('/api/sensoren', App\Controllers\sensoren::class . ':showAllSensoren');

$app->post('/api/sensoren', App\Controllers\sensoren::class . ':addSensor');


$app->get('/api/sensoren/{id:[0-9]+}', function(Request $request, Response $response, string $id){
   
    $repository = $this->get(App\Repositories\SensorRepository::class);
    $data = $repository->getSensorById((int)$id);
    
    if($data === false) {
        throw new \Slim\Exception\HttpNotFoundException($request, message:"Sensor bestaat niet");
    }

    $body = json_encode($data);
    $response->getBody()->write($body);

    return $response->withHeader('Content-Type', 'application/json');

});





$app->get('/api/meting', function(Request $request, Response $response) {

    $repository = $this->get (App\Repositories\MetingRepository::class);

    $data = $repository->getAllMeting();

    $body = json_encode($data);

    $response->getBody()->write($body);

    return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/api/meting/{id:[0-9]+}', function(Request $request, Response $response, string $id){
   
    $repository = $this->get(App\Repositories\MetingRepository::class);
    $data = $repository->getMetingById((int)$id);
    
    if($data === false) {
        throw new \Slim\Exception\HttpNotFoundException($request, message:"Meting bestaat niet");
    }

    $body = json_encode($data);
    $response->getBody()->write($body);

    return $response->withHeader('Content-Type', 'application/json');

});

$app->run();