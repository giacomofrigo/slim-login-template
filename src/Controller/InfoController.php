<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


final class InfoController extends BaseController
{
    public function __invoke(Request $request, Response $response): Response {

        $response->getBody()->write(json_encode(
            ['app-name' => $this->container->get("settings")["app-name"],
             'version' => $this->container->get("settings")["app-version"]]));
        $json_response = $response->withHeader('Content-type', 'application/json');
        
        return $json_response;
    }
}