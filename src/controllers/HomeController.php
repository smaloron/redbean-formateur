<?php
namespace slimApp\controllers;

use DI\Container;
use Exception;
use Psr\Http\Message\ResponseInterface;

class HomeController extends AbstractWebController{

    public function hello(ResponseInterface $response, $name = "Inconnu"){

        return $this->render(
            $response, 
            "hello.twig", 
            [
                "name" => $name,
                "skills" => [],
                "showSkills" => true
            ]
        );

    }
}