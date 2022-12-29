<?php

namespace Bitrix24Api;

use Bitrix24Api\Batch\Command;
use Symfony\Contracts\HttpClient\ResponseInterface;

class Response
{
    protected ResponseInterface $httpResponse;
    private ?DTO\ResponseData $responseData;
    protected Command $apiCommand;

    public function __construct(ResponseInterface $httpResponse, Command $apiCommand)
    {
        $this->httpResponse = $httpResponse;
        $this->responseData = null;
        $this->apiCommand = $apiCommand;
    }

    public function getResponseData(): ?DTO\ResponseData
    {
        if ($this->responseData === null) {
            try {
                $responseResult = $this->httpResponse->toArray(true);
                if (!is_array($responseResult['result'])) {
                    $responseResult['result'] = [$responseResult['result']];
                }

                $nextItem = null;
                $total = null;
                if (array_key_exists('next', $responseResult)) {
                    $nextItem = (int)$responseResult['next'];
                }
                if (array_key_exists('total', $responseResult)) {
                    $total = (int)$responseResult['total'];
                }
                $this->responseData = new DTO\ResponseData(
                    new DTO\Result($responseResult['result']),
                    DTO\Time::initFromResponse($responseResult['time']),
                    new DTO\Pagination($nextItem, $total),
                    $this->apiCommand
                );
            } catch (\Exception $exception) {

            }
        }
        return $this->responseData;
    }
}
