<?php

namespace Bitrix24Api\Http;

use Bitrix24Api\Http\Providers\HttpDecorator;
use Bitrix24Api\Http\Validators\ResponseValidator;
use Bitrix24Api\Response;
use Psr\Log\LoggerAwareTrait;
use Symfony\Contracts\HttpClient\ResponseInterface;

class HttpRequest extends HttpDecorator
{
    use LoggerAwareTrait;

    public function request(string $url, array $options): ResponseInterface
    {
        if ($this->logger !== null) {
            $this->logger->debug(
                //sprintf('request.start %s', $method),
                sprintf('request.start %s', $url),
                [
                    'params' => $options['json'],
                ]
            );
        }

        $response = parent::request($url, $options);

        if ($this->logger !== null) {
            //$message = sprintf('request.end %s', $method);
            $message = sprintf('request.end %s', $url);
            $context = [
                'httpStatus' => $response->getStatusCode(),
                'body' => $response->toArray(false)
            ];

            $this->logger->debug($message, $context);
        }

        return $response;
    }
}
