<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class ErrorException extends Exception
{
    private $name;
    private $params;
    private $statusCode;


    public function __construct($name, $params = [], $statusCode = 400)
    {
        $this->name = $name;
        $this->params = $params;
        $this->statusCode = $statusCode;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }
}
