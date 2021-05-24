<?php

namespace App\Exception;

use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

final class NotFoundException extends BaseException
{
    public function __construct(
        string $message = "Not found", 
        int $returncode = 404,
        array $errors = []
    ){
        parent::__construct($message, $returncode, $errors);

    }
}
