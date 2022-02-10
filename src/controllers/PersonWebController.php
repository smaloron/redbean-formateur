<?php
namespace slimApp\controllers;

use Psr\Http\Message\ResponseInterface;
use RedBeanPHP\R as R;

class PersonWebController extends AbstractWebController {

    public function showAll(ResponseInterface $response){
        $persons = R::findAll("person");
        return $this->render(
            $response, 
            "person/all.twig", [
            "personList" => $persons]
        );
    }

    public function showOne($id, ResponseInterface $response){
        $person = R::load("person", $id);
    
        return $this->render(
            $response, 
            "person/detail.twig", [
            "person" => $person]
        );
    }

    public function showForm(ResponseInterface $response){
        return $this->render(
            $response, 
            "person/form.twig", []
        );
    }

}