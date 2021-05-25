<?php
namespace App\Controller;

use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

abstract class BaseController
{
    protected $container;  

    public function __construct(ContainerInterface $container)
    {   
        $this->container = $container;
    }
}