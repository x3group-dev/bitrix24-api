<?php

namespace Bitrix24Api\DTO;

class Result
{
    /**
     * @var array
     */
    protected $result;

    /**
     * Result constructor.
     *
     * @param array $result
     */
    public function __construct(array $result)
    {
        $this->result = $result;
    }

    /**
     * @return array
     */
    public function getResultData(): array
    {
        return $this->result;
    }
}