<?php

namespace Bitrix24Api\Models\Task;

use Bitrix24Api\Models\AbstractModel;
use Bitrix24Api\Models\Interfaces\HasIdInterface;

class CommentItemModel extends AbstractModel implements HasIdInterface
{
    public function toArray(): array
    {
        return $this->data;
    }

    public function getId(): int
    {
        return (int)$this->ID;
    }

    public function getAuthorId(): int
    {
        return (int)$this->AUTHOR_ID;
    }

    public function getAuthorName(): string
    {
        return $this->AUTHOR_NAME;
    }

    public function getPostDate(): string
    {
        return $this->POST_DATE;
    }

    public function getPostMessage(): string
    {
        return $this->POST_MESSAGE;
    }

    public function getAttachedObjects(): array
    {
        return $this->ATTACHED_OBJECTS ?? [];
    }
}
