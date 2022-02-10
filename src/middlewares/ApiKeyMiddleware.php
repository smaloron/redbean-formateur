<?php

namespace slimApp\middlewares;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ApiKeyMiddleware {

    private string $correctKey;

    public function __construct(string $goodKey)
    {
        $this->correctKey = $goodKey;   
    }

    public function __invoke(
        RequestInterface $request,
        RequestHandlerInterface $handler
    )
    {
        $key = filter_input(INPUT_GET, "key");
        if($key != $this->correctKey){
            throw new \Exception("Clef non valide");
        }
        $response = $handler->handle($request);
        return $response;
    }
}