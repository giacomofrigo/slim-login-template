<?php
namespace App\Middleware;

use App\Exception\AccessForbiddenException;
use App\Exception\NotLoggedInException;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

final class AuthMiddleware{

    private $roles;

    public function __construct($roles = [])
    {
        $this->roles = $roles;
    }

    /**
     * Example middleware invokable class
     *
     * @param  ServerRequest  $request PSR-7 request
     * @param  RequestHandler $handler PSR-15 request handler
     *
     * @return Response
     */
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        
        if (isset($_SESSION['user'])) {
            if (empty($this->roles)){
                $response = $handler->handle($request);
                return $response;
            }
               

            if ((in_array($_SESSION['user']['role'], $this->roles)) || ($_SESSION['user']['role'] == 'admin')){
                $response = $handler->handle($request);
                return $response;
            }else{
                throw new AccessForbiddenException("You are not allowed to access this resource", ["role" => $_SESSION['user']['role'], 'required' => $this->roles]);
            }
        }
        else{
            throw new AccessForbiddenException("You are not allowed to access this resource", ["role" => $_SESSION['user']['role'], 'required' => $this->roles]);
        }    
    }

}