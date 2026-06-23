<?php

namespace Bitrix24Api\Exceptions;

class OperationTimeLimitExceeded extends ApiException
{
    private string $method;
    private int $operatingResetAt;
    private int $retryAfterSeconds;
    private array $responseBody;

    public function __construct(
        string $method,
        int $operatingResetAt,
        ?int $currentTime = null,
        string $message = 'OPERATION_TIME_LIMIT',
        string $description = '',
        array $responseBody = [],
    ) {
        parent::__construct($message, 429, $description);

        $this->method = $method;
        $this->operatingResetAt = $operatingResetAt;
        $this->retryAfterSeconds = max(1, $operatingResetAt - ($currentTime ?? time()));
        $this->responseBody = $responseBody;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getOperatingResetAt(): int
    {
        return $this->operatingResetAt;
    }

    public function getRetryAfterSeconds(): int
    {
        return $this->retryAfterSeconds;
    }

    public function getResponseBody(): array
    {
        return $this->responseBody;
    }
}
