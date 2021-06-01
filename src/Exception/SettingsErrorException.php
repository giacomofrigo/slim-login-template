<?php

namespace App\Exception;

use RuntimeException;
use Throwable;

class SettingsErrorException extends BaseException
{
    public function __construct(
        string $message = "settings error", 
        int $returncode = 500,
        array $errors = []
    ){
        parent::__construct($message, $returncode, $errors);

    }

}