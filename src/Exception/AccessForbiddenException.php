<?php

namespace App\Exception;

use App\Exception\BaseException;

final class AccessForbiddenException extends BaseException
{
    public function __construct(
        string $message = "You are not allowed to access this resource", 
        int $returncode = 403,
        array $errors = []
    ){
        parent::__construct($message, $returncode, $errors);

    }

}
