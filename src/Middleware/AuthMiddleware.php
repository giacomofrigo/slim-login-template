<?php
namespace App\Middleware;

use App\Exception\AccessForbiddenException;
use App\Exception\NotLoggedInException;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

final class AuthMiddleware{

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
        
        
        if (isset($_SESSION['user'])){
            $response = $handler->handle($request);
            return $response;
        }
        else{
            throw new AccessForbiddenException();
        }    
    }

}