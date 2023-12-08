<?php

declare(strict_types=1);

namespace App\Services\UserGateway\Exceptions;

use Exception;
use Throwable;

class InvalidSsoResponseException extends Exception
{
    /**
     * Errors list
     *
     * @var array
     */
    protected array $errors;

    /**
     * InvalidAccountsResponseException constructor.
     *
     * @param string          $message
     * @param int             $code
     * @param array           $errors
     * @param \Throwable|null $previous
     */
    public function __construct(string $message = "", int $code = 0, array $errors = [], Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->errors = $errors;
    }

    /**
     * Return errors list.
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
