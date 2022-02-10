<?php

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Factory\AppFactory;
use RedBeanPHP\R as R;
use slimApp\controllers\PersonController;
use slimApp\controllers\HomeController;

use DI\Bridge\Slim\Bridge;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use slimApp\middlewares\TestMiddleware;

use Middlewares\Whoops;
use Slim\Routing\RouteCollectorProxy;
use Slim\Interfaces\RouteCollectorProxyInterface;
use slimApp\middlewares\ApiKeyMiddleware;

use Slim\Views\Twig;
use slimApp\controllers\PersonWebController;

require "../vendor/autoload.php";

$dev = false;

// Initialisation de RedBean
R::setup(
    "mysql:host=localhost;dbname=redbean;charset=utf8",
    "root",
    "1234"
);

$builder = new DI\ContainerBuilder();
$container = $builder->build();

$container->set("twig", function(){
    return Twig::create("../views");
});

$middleware = function(RequestInterface $request, RequestHandlerInterface $handler){
    $response = $handler->handle($request);
    $response->getBody()->write("Hello from middleware");
    return $response;
};
$middleware2 = function(RequestInterface $request, RequestHandlerInterface $handler){
    $response = $handler->handle($request);
    $response->getBody()->write("End of response");
    return $response;
};

$app = Bridge::create($container); 

//$app->add($middleware);
if($dev){
    $app->add(Whoops::class);
}



$app->get("/hello[/{name}]", [HomeController::class, "hello"])
->add($middleware)->add($middleware2)->add(new TestMiddleware());

$app->group("/api/person", function(RouteCollectorProxyInterface $group){
    $group->get("/insert/{firstName}/{lastName}",
            [PersonController::class, "insert"]);

    $group->get("/all", [PersonController::class, "showAll"]);
    $group->get("/{id}", [PersonController::class, "showOne"]);
})->add(new ApiKeyMiddleware("123"));

$app->group("/person", function(RouteCollectorProxyInterface $group){
    $group->get("/", [PersonWebController::class,"showAll"]);
    $group->get("/{id:[0-9]+}", [PersonWebController::class,"showOne"]);
    $group->get("/form", [PersonWebController::class,"showForm"]);
});


$app->run();