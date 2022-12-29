<?php

declare(strict_types=1);

namespace Bitrix24Api\Config;

class Credential
{
    protected string $accessToken;
    protected string $refreshToken;
    protected int $expires;
    protected string $domain;
    protected string $serverEndpoint;
    protected string $clientEndpoint;
    protected string $memberId;
    protected int $userId;
    protected string $status;

    /**
     * Credential constructor.
     *
     * @param string $accessToken
     * @param string $refreshToken
     * @param int $expires
     */
    public function __construct(string $accessToken, int $expires, string $domain, string $serverEndpoint, string $clientEndpoint, string $memberId, int $userId, string $refreshToken, string $status)
    {
        $this->accessToken = $accessToken;
        $this->expires = $expires;
        $this->domain = $domain;
        $this->serverEndpoint = $serverEndpoint;
        $this->clientEndpoint = $clientEndpoint;
        $this->memberId = $memberId;
        $this->userId = $userId;
        $this->refreshToken = $refreshToken;
        $this->status = $status;
    }

    /**
     * @param array $request
     *
     * @return self
     */
    public static function initFromArray(array $request): self
    {
        return new self(
            (string)$request['access_token'],
            (int)$request['expires'],
            (string)$request['domain'],
            isset($request['server_endpoint']) ? (string)$request['server_endpoint'] : '',
            (string)$request['client_endpoint'],
            (string)$request['member_id'],
            isset($request['user_id']) ? (int)$request['user_id'] : 0,
            (string)$request['refresh_token'],
            (string)$request['status']
        );
    }

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    /**
     * @return string
     */
    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }

    /**
     * @return bool
     */
    public function isExpired(): bool
    {
        return $this->getExpires() <= time();
    }

    /**
     * @return int
     */
    public function getExpires(): int
    {
        return $this->expires;
    }

    public function setFromArray(array $request)
    {
        if (isset($request['access_token']) && !empty($request['access_token']))
            $this->accessToken = $request['access_token'];

        if (isset($request['expires']) && (int)($request['expires']) > 0)
            $this->expires = (int)$request['expires'];

        if (isset($request['domain']) && !empty($request['domain']))
            $this->domain = $request['domain'];

        if (isset($request['server_endpoint']) && !empty($request['server_endpoint']))
            $this->serverEndpoint = $request['server_endpoint'];

        if (isset($request['client_endpoint']) && !empty($request['client_endpoint']))
            $this->clientEndpoint = $request['client_endpoint'];

        if (isset($request['member_id']) && !empty($request['member_id']))
            $this->memberId = $request['member_id'];

        if (isset($request['user_id']) && (int)($request['user_id']) > 0)
            $this->userId = (int)$request['user_id'];

        if (isset($request['refresh_token']) && !empty($request['refresh_token']))
            $this->refreshToken = $request['refresh_token'];

        if (isset($request['status']) && !empty($request['status']))
            $this->status = $request['status'];
    }

    public function toArray(): array
    {
        return [
            'access_token' => $this->accessToken,
            'expires' => $this->expires,
            'domain' => $this->domain,
            'server_endpoint' => $this->serverEndpoint,
            'client_endpoint' => $this->clientEndpoint,
            'member_id' => $this->memberId,
            'user_id' => $this->userId,
            'refresh_token' => $this->refreshToken,
            'status' => $this->status
        ];
    }

    /**
     * @return string
     */
    public function getClientEndpoint(): string
    {
        return $this->clientEndpoint;
    }

    /**
     * @param string $clientEndpoint
     */
    public function setClientEndpoint(string $clientEndpoint): void
    {
        $this->clientEndpoint = $clientEndpoint;
    }

    /**
     * @return string
     */
    public function getDomain(): string
    {
        return $this->domain;
    }

    /**
     * @param string $domain
     */
    public function setDomain(string $domain): void
    {
        $this->domain = $domain;
    }

    /**
     * @return string
     */
    public function getServerEndpoint(): string
    {
        return $this->serverEndpoint;
    }

    /**
     * @param string $serverEndpoint
     */
    public function setServerEndpoint(string $serverEndpoint): void
    {
        $this->serverEndpoint = $serverEndpoint;
    }

    /**
     * @return string
     */
    public function getMemberId(): string
    {
        return $this->memberId;
    }

    /**
     * @param string $memberId
     */
    public function setMemberId(string $memberId): void
    {
        $this->memberId = $memberId;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }
}

/* reply sample
Array
(
    [access_token] => f9b8f361005924e600005bb4000000030000034de68362375794e2ce7193cbf08c71ae
    [expires] => 1643362553
    [domain] => oauth.bitrix.info
    [server_endpoint] => https://oauth.bitrix.info/rest/
    [client_endpoint] => https://altasib.bitrix24.ru/rest/
    [member_id] => d8ec73f4795c05836fdc9f52588fca4d
    [user_id] => 3
    [refresh_token] => e9371b62005924e600005bb400000003000003fc28b6b7f0522e64cb2b404acc04c2ba
    [status] => L
)
 */