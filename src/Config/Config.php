<?php

namespace Bitrix24Api\Config;

use Psr\Log\LoggerInterface;

class Config
{
    protected string $webHookUrl = '';
    protected ?Application $applicationConfig;
    protected ?Credential $credential;
    protected ?LoggerInterface $logger;

    public function __construct(?string $url, ?Application $applicationConfig, ?Credential $credential, ?LoggerInterface $logger = null)
    {
        $this->logger = $logger;

        if ($applicationConfig && $credential) {
//            $this->setClientEndpoint($url);
            $this->setCredential($credential);
            $this->setApplicationConfig($applicationConfig);
        } else {
            $this->setWebHookUrl($url);
        }
//        if ($this->logger) {
//            $this->logger->debug(
//                'Api.init',
//                [
//                    'webhookMode' => $this->isWebHookMode(),
//                ]
//            );
//        }
    }

    /**
     * @return bool
     */
    public function isWebHookMode(): bool
    {
        return !empty($this->webHookUrl);
    }

    /**
     * @return string
     */
    public function getWebHookUrl(): string
    {
        return $this->webHookUrl;
    }

    /**
     * @param string $url
     */
    public function setWebHookUrl(string $url)
    {
        $this->webHookUrl = $url;
    }

    /**
     * @return Application
     */
    public function getApplicationConfig(): Application
    {
        return $this->applicationConfig;
    }

    /**
     * @param Application $applicationConfig
     */
    public function setApplicationConfig(Application $applicationConfig): void
    {
        $this->applicationConfig = $applicationConfig;
    }

    /**
     * @return Credential
     */
    public function getCredential(): Credential
    {
        return $this->credential;
    }

    /**
     * @param Credential $credential
     */
    public function setCredential(Credential $credential): void
    {
        $this->credential = $credential;
    }

    /**
     * @return LoggerInterface|null
     */
    public function getLogger(): ?LoggerInterface
    {
        return $this->logger;
    }
}
