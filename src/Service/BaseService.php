<?php
namespace App\Service;

use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

abstract class BaseService
{
    protected $logger; // logger
    protected $em;  // Entities Manager

    public function __construct(ContainerInterface $container)
    {
        $this->logger = $container->get(LoggerInterface::class);
        $this->em = $container->get('em');
    }

    public function getLogger(){
        return $this->logger;
    }

    public function getEntityManager(){
        return $this->em;
    }
}