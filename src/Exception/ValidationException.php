<?php

namespace App\Exception;

final class ValidationException extends BaseException
{
    public function __construct(
        string $message = "Fields validation failed!", 
        int $returncode = 400,
        array $errors = []
    ){
        parent::__construct($message, $returncode, $errors);

    }

}
