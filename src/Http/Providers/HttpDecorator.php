<?php

namespace Bitrix24Api\Http\Providers;

use Bitrix24Api\Http\Interfaces\Providers\HttpProviderInterface;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\ExpectedValues;
use Symfony\Contracts\HttpClient\ResponseInterface;

class HttpDecorator implements HttpProviderInterface
{
    protected HttpProviderInterface $provider;

    public function __construct(HttpProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    #[ArrayShape(['GET', 'HEAD', 'POST', 'PUT', 'DELETE', 'CONNECT', 'OPTIONS', 'TRACE', 'PATCH'])]
    public function getMethod(): string
    {
        return $this->getProvider()->getMethod();
    }

    public function setMethod(
        #[ExpectedValues(['GET', 'HEAD', 'POST', 'PUT', 'DELETE', 'CONNECT', 'OPTIONS', 'TRACE', 'PATCH'])]
        string $method
    ): HttpProviderInterface
    {
        return $this->getProvider()->setMethod($method);
    }

    /**
     * @param string $url
     * @param array $options
     * @return ResponseInterface
     */
    public function request(string $url, array $options)
    {
        return $this->getProvider()->request($url, $options);
    }

    protected function getProvider(): HttpProviderInterface
    {
        return $this->provider;
    }
}
