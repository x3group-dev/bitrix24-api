<?php

namespace Bitrix24Api\Models\Sonet;

use Bitrix24Api\Models\AbstractModel;
use Bitrix24Api\Models\Interfaces\HasIdInterface;

class GroupModel extends AbstractModel implements HasIdInterface
{
    public function toArray(): array
    {
        return $this->data;
    }

    public function getId(): int
    {
        return (int)$this->ID;
    }

    public function getSiteId(): string
    {
        return $this->SITE_ID;
    }

    public function getName(): string
    {
        return $this->NAME;
    }

    public function getDescription(): string
    {
        return $this->DESCRIPTION;
    }

    public function getDateCreate(): string
    {
        return $this->DATE_CREATE;
    }

    public function getDateUpdate(): ?string
    {
        return $this->DATE_UPDATE;
    }

    public function isActive(): bool
    {
        return $this->ACTIVE === 'Y';
    }

    public function isVisible(): bool
    {
        return $this->VISIBLE === 'Y';
    }

    public function isOpened(): bool
    {
        return $this->OPENED === 'Y';
    }

    public function isClosed(): bool
    {
        return $this->CLOSED === 'Y';
    }

    public function getSubjectId(): int
    {
        return (int)$this->SUBJECT_ID;
    }

    public function getOwnerId(): int
    {
        return (int)$this->OWNER_ID;
    }

    public function getKeywords(): ?string
    {
        return $this->KEYWORDS;
    }

    public function getNumbersOfMembers(): int
    {
        return (int)$this->NUMBER_OF_MEMBERS;
    }

    public function getDateActivity(): ?string
    {
        return $this->DATE_ACTIVITY;
    }

    public function getSubjectName(): ?string
    {
        return $this->SUBJECT_NAME;
    }

    public function isProject(): bool
    {
        return $this->PROJECT === 'Y';
    }

    public function isExtranet(): bool
    {
        return $this->IS_EXTRANET === 'Y';
    }
}
