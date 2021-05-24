<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Model\User;
use App\Service\UserService;

final class UserController extends BaseController
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


    public function newUser(Request $request, Response $response): Response {
        
        // Collect input from the HTTP request
        $data = (array)$request->getParsedBody();

        $user = $this->userService->createUser($data);
        $response->getBody()->write(json_encode(['success' => true]));
        $json_response = $response->withHeader('Content-type', 'application/json');
        
        return $json_response;
    }

    public function login(Request $request, Response $response): Response {
        
        // user alredy authenticated
        if (isset($_SESSION['user'])){
            $response->getBody()->write(json_encode(['success' => true, 'user' => $_SESSION['user']]));
            return $response->withHeader('Content-type', 'application/json');
        }

        // Collect input from the HTTP request
        $data = (array)$request->getParsedBody();
        
        //check username and password
        $user = $this->userService->login($data);
        //set the session and send response
        if (!is_null($user)){
            $_SESSION['user'] = $user->toArray();
            $response->getBody()->write(json_encode(['success' => true, 'user' => $_SESSION['user']]));
                                    
        }else{
            $response->getBody()->write(json_encode(['success' => false]));
            
        }

        return $response->withHeader('Content-type', 'application/json');
        
    }

    public function logout(Request $request, Response $response): Response {
        $user = $_SESSION['user'];
        unset($_SESSION['user']);
        session_regenerate_id();
        $this->userService->getLogger()->info(sprintf("User %s successfully logged out.", $user['username']));
        
        //create json response
        $response->getBody()->write(json_encode(['success' => true]));

        return $response->withHeader('Content-type', 'application/json');
        
    }

    public function getUserInfo(Request $request, Response $response): Response {
        $this->userService->getLogger()->debug(sprintf("Getting info about user %s", $_SESSION['user']['username']));
        $response->getBody()->write(json_encode($_SESSION['user']));
        return $response->withHeader('Content-type', 'application/json');
        
    }
}