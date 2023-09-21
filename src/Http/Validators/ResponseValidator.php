<?php

namespace Bitrix24Api\Http\Validators;

use Bitrix24Api\Exceptions\ApiException;
use Bitrix24Api\Exceptions\ApplicationNotInstalled;
use Bitrix24Api\Exceptions\ExpiredRefreshToken;
use Bitrix24Api\Exceptions\ServerInternalError;
use Exception;
use Symfony\Contracts\HttpClient\ResponseInterface;

class ResponseValidator
{
    protected ResponseInterface $response;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public function validate(): self
    {
        $body = $this->response->toArray(false);
        $status = $this->response->getStatusCode();
        $checkers = $this->getCheckers();

        if (in_array($status, $checkers)) {
            call_user_func_array($checkers[$status], [$body]);
        } else {
            throw new ApiException('http status not found', -1);
        }

        return $this;
    }

    protected function serverError(array $body): void
    {
        throw new ServerInternalError('request: 500 internal error');
    }

    protected function unauthorized(array $body): void
    {
        if ($body['error'] == 'expired_token') {
            throw new ExpiredRefreshToken();
        }

        if ($body['error'] === 'ERROR_OAUTH' && $body['error_description'] === 'Application not installed') {
            throw new ApplicationNotInstalled();
        }
    }

    protected function badCallResponse(array $body): void
    {
        if (empty($body['error'])) {
            throw new ApiException((string)$body['error'], 400, $body['error_description']);
        }
    }

    protected function notFoundResponse(array $body): void
    {
        if (empty($body['error']) && $body['error'] === 'ERROR_METHOD_NOT_FOUND') {
            throw new Exception($body['error']);
        }
    }

    protected function getCheckers(): array
    {
        return [
            404 => [$this, 'notFoundResponse'],
            400 => [$this, 'badCallResponse'],
            401 => [$this, 'unauthorized'],
            500 => [$this, 'serverError']
        ];
    }
}
