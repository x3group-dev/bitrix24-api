<?php

namespace Bitrix24Api;

use Throwable;

use Bitrix24Api\Batch\Command;

use Symfony\Contracts\HttpClient\ResponseInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

use Psr\Log\LoggerAwareTrait;
use JetBrains\PhpStorm\ArrayShape;

class Response
{
    use LoggerAwareTrait;

    protected ResponseInterface $httpResponse;
    private ?DTO\ResponseData $responseData = null;
    protected Command $apiCommand;

    public function __construct(ResponseInterface $httpResponse, Command $apiCommand)
    {
        $this->httpResponse = $httpResponse;
        $this->apiCommand = $apiCommand;
    }

    /**
     * Получение данных http ответа.
     *
     * @return DTO\ResponseData|null
     *
     * @author Daniil S.
     */
    public function getResponseData(): ?DTO\ResponseData
    {
        if ($this->responseData === null) {
            $this->responseData = $this->makeResponseData();
        }

        return $this->responseData;
    }

    /**
     * Формирование объекта хранения преобразованных данных ответа.
     * Данные, для формирования
     *
     * @return DTO\ResponseData|null
     *
     * @author Daniil S.
     */
    protected function makeResponseData(): ?DTO\ResponseData
    {
        $result = null;

        try {
            $response = $this->getHttpResponse();

            $result = new DTO\ResponseData(
                new DTO\Result($response['result']),
                DTO\Time::initFromResponse($response['time']),
                new DTO\Pagination($response['next'], $response['total']),
                $this->apiCommand
            );

        } catch (Throwable $throwable) {
            if ($this->logger !== null) {
                $this->logger->error($throwable->getMessage());
            }
        }

        return $result;
    }

    /**
     * Получение преобразованного http ответа.
     *
     * @return array
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     *
     * @author Daniil S.
     */
    protected function getHttpResponse(): array
    {
        $response = $this->httpResponse->toArray(true);
        return $this->prepareHttpResponse($response);
    }

    /**
     * Преобразование http ответа.
     *
     * @param array $response
     * @return array
     *
     * @author Daniil S.
     */
    #[ArrayShape(['total' => 'int', 'next' => 'int', 'result' => 'array', 'time' => 'array'])]
    protected function prepareHttpResponse(array $response): array
    {
        if (isset($response['result'])) {
            if (!is_array($response['result'])) {
                $response['result'] = [$response['result']];
            }
        } else {
            $response['result'] = [];
        }

        if (!isset($response['time']) || !is_array($response['time'])) {
            $response['time'] = [];
        }

        $response['next'] = isset($response['next']) && is_numeric($response['next']) ? intval($response['next']) : null;
        $response['total'] = isset($response['total']) && is_numeric($response['total']) ? intval($response['total']) : null;

        return $response;
    }
}
