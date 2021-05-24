<?php

namespace App\Exception;

use Psr\Container\ContainerInterface;
use RuntimeException;
use Throwable;

class BaseException extends RuntimeException
{
    private $errors;
    private $returncode;

    public function __construct(
        string $message, 
        int $returncode,
        array $errors = [], 
        Throwable $previous = null
    ){
        parent::__construct($message, $returncode, $previous);

        $this->errors = $errors;
        $this->returncode = $returncode;
    }

    public function getErrors(): array{
        return $this->errors;
    }

    public function getReturnCode(): int{
        return $this->returncode;
    }
    
    public function toArray(): array{
        $array = array ();
        $array['message'] = $this->message;
        $array['errors'] = $this->errors;
        $array['returncode'] = $this->returncode;
        return $array;
        
    }

    
}
