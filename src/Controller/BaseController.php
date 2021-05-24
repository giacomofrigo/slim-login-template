<?php
namespace App\Controller;

use Doctrine\DBAL\Logging\LoggerChain;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;

abstract class BaseController
{
    protected $logger;  

    public function __construct(LoggerInterface $logger)
    {   
        $this->logger = $logger;
    }
}