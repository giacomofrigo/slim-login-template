<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Model\User;

final class InfoController extends BaseController
{
    public function __invoke(Request $request, Response $response): Response {
        
        $userRepository = $this->em->getRepository(User::class);
        $users = $userRepository->findAll();
        $response->getBody()->write(json_encode(['username' => $users[0]->getUsername()]));
        $json_response = $response->withHeader('Content-type', 'application/json');
        
        return $json_response;
    }
}