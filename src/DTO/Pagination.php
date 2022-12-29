<?php

namespace Bitrix24Api\DTO;

class Pagination
{
    /**
     * @var int|null
     */
    private $nextItem;
    /**
     * @var int|null
     */
    private $total;

    /**
     * Pagination constructor.
     *
     * @param int|null $nextItem
     * @param int|null $total
     */
    public function __construct(int $nextItem = null, int $total = null)
    {
        $this->nextItem = $nextItem;
        $this->total = $total;
    }

    /**
     * @return int|null
     */
    public function getNextItem(): ?int
    {
        return $this->nextItem;
    }

    /**
     * @return int|null
     */
    public function getTotal(): ?int
    {
        return $this->total;
    }
}