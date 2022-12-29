<?php

namespace Bitrix24Api\Config;

class Application
{
    protected string $clientId;
    protected string $clientSecret;

    public function __construct(string $clientId, string $clientSecret)
    {
        $this->setClientId($clientId);
        $this->setClientSecret($clientSecret);
    }

    /**
     * @return string
     */
    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }

    /**
     * @param string $clientSecret
     */
    public function setClientSecret(string $clientSecret): void
    {
        $this->clientSecret = $clientSecret;
    }

    /**
     * @return string
     */
    public function getClientId(): string
    {
        return $this->clientId;
    }

    /**
     * @param string $clientId
     */
    public function setClientId(string $clientId): void
    {
        $this->clientId = $clientId;
    }
}