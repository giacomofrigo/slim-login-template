<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controller\LoggerTestController;
use App\Service\UserService;


final class LoggerController extends LoggerTestController
{
    protected $userService;
    public function __constructor(UserService $userService){
        $this->userService = $userService;
    }
    public function check_log(Request $request, Response $response): Response {
        
        $this->logger->info("check");
        $this->userService->pass();
        $response->getBody()->write(json_encode(['success' => true]));
        return $response;
    }
}