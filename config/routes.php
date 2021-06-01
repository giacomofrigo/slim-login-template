<?php

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;
use App\Controller\InfoController;
use App\Controller\LoggerController;
use App\Controller\UserController;
use App\Middleware\AuthMiddleware;

return function (App $app) {
    $app->get('/', InfoController::class)->setName('info');

    $app->post('/login', [UserController::class, 'login'])->setName('login');
    $app->get('/logout', [UserController::class, 'logout'])->setName('logout')->add(new AuthMiddleware());

    $app->post('/user', [UserController::class, 'newUser'])->setName('newUser');
    
    $app->get('/user', [UserController::class, 'getUserInfo'])->setName('userInfo')->add(new AuthMiddleware(["professor"]));

   
};
