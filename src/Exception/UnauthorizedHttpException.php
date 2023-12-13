<?php
// src/Exception/UnauthorizedHttpException.php

namespace App\Exception;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class UnauthorizedHttpException extends HttpException
{
    public function __construct(ParameterBagInterface $parameterBag, $message = null, \Exception $previous = null, $code = 0, array $headers = [])
    {
        parent::__construct($parameterBag->get('http_status_codes')['unauthorized'], $message, $previous, $headers, $code);
    }
}
