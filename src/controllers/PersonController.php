<?php
namespace slimApp\controllers;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use RedBeanPHP\R as R;
class PersonController {

    public function showAll(
        ResponseInterface $response
    ){

        $list = R::findAll("person");
        $response->getBody()->write(json_encode($list));
        return $response;

    }

    public function showOne(
        $id,
        ResponseInterface $response
    ){
        $response->getBody()->write($id);
        return $response;
    }

    public function insert(
        ResponseInterface $response, $firstName, $lastName
    ){
    
        $p = R::dispense("person");
    
        $p->firstName = $firstName;
        $p->lastName = $lastName;
    
        $id = R::store($p);
    
        $response->getBody()->write("l'id est $id");
    
        return $response;
    
    }

}