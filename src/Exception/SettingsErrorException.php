<?php

namespace App\Exception;

use RuntimeException;
use Throwable;

class SettingsErrorException extends RuntimeException{
    public function __construct(
        string $message, 
        int $returncode,
        array $errors = [], 
        Throwable $previous = null
    ){
        parent::__construct($message, $returncode, $previous);

    }
}