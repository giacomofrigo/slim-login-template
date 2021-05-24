<?php

use App\Exception\BaseException;
use Monolog\Logger;
use Slim\App;
use Slim\Middleware\ErrorMiddleware;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use Psr\Http\Message\ServerRequestInterface;
use Slim\Factory\AppFactory;
use Slim\Psr7\Response as SlimReponse;
use Psr\Log\LoggerInterface;

return function (App $app) {

    // Parse json, form data and xml
    $app->addBodyParsingMiddleware();

    // Add the Slim built-in routing middleware
    $app->addRoutingMiddleware();

    // Catch exceptions and errors
    // default error handler
    //$app->add(ErrorMiddleware::class);

    // Define Custom Error Handler
    $customErrorHandler = function (
        ServerRequestInterface $request,
        Throwable $exception,
        bool $displayErrorDetails,
        bool $logErrors,
        bool $logErrorDetails,
        ?LoggerInterface $logger = null
    ) use ($app) {

        //$app->getContainer()->get(LoggerInterface::class)->error($exception->getMessage());

        $payload = array();
        $response = new SlimReponse();        

        if (is_a($exception, "App\\Exception\\BaseException")){
            $payload ['statusCode'] = $exception->getReturnCode();
            $payload ['errors'] = $exception->getErrors();
            $response = $response->withStatus($payload['statusCode']);
        }else{
            $response = $response->withStatus(500);
        }

        $payload ['message'] = $exception->getMessage();
        
        //$payload ['exception_type'] = get_class($exception);
        
        $response = $response->withAddedHeader('Content-type', 'application/json');
        $response->getBody()->write(
            json_encode($payload, JSON_UNESCAPED_UNICODE)
        );

        return $response;
    };

    // Add Error Middleware
    $errorMiddleware = $app->addErrorMiddleware(true, true, true);
    $errorMiddleware->setDefaultErrorHandler($customErrorHandler);
};