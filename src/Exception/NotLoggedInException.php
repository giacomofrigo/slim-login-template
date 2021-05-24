<?php

namespace App\Exception;

use App\Exception\BaseException;
use Psr\Container\ContainerInterface;

final class NotLoggedInException extends BaseException
{
    public function __construct(
        string $message = "Login required", 
        int $returncode = 403,
        array $errors = []
    ){
        parent::__construct($message, $returncode, $errors);

    }

}
