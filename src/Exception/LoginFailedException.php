<?php

namespace App\Exception;

use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

final class LoginFailedException extends BaseException
{
    public function __construct(
        string $message = "Login failed", 
        int $returncode = 500,
        array $errors = []
    ){
        parent::__construct($message, $returncode, $errors);

    }
}
