<?php

declare(strict_types=1);

namespace App\Services\HttpCaller;

use Psr\Http\Message\ResponseInterface;

interface MakesHttpRequest
{
    public function init(array $config = []): MakesHttpRequest;

    public function exec(string $method, string $url, array $options = []): ResponseInterface;
}
