<?php

namespace Bitrix24Api\Models\Task;

use Bitrix24Api\Models\AbstractModel;
use Bitrix24Api\Models\Interfaces\HasIdInterface;

class TaskModel extends AbstractModel implements HasIdInterface
{
    public function toArray(): array
    {
        return $this->data;
    }

    public function getId(): ?int
    {
        return (int)$this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getFavorite(): string
    {
        return $this->favorite;
    }

    public function getResponsibleId(): int
    {
        return (int)$this->responsibleId;
    }

    public function getResponsible(): array
    {
        return $this->responsible;
    }

    public function getCreatedBy(): int
    {
        return (int)$this->createdBy;
    }

    public function createdDate(): string
    {
        return (int)$this->createdDate;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getCreator(): array
    {
        return $this->creator;
    }

    public function getAction(): array
    {
        return $this->action;
    }

    public function getGroup(): array
    {
        return $this->group;
    }

    public function getGroupId(): ?int
    {
        return $this->groupId;
    }

    public function getDeadline(): ?string
    {
        return $this->deadline;
    }

    public function getClosedDate(): ?string
    {
        return $this->closedDate;
    }

    public function getStartDatePlan(): ?string
    {
        return $this->startDatePlan;
    }

    public function getEndDatePlan(): ?string
    {
        return $this->endDatePlan;
    }

    public function getPriority(): ?string
    {
        return $this->priority;
    }

    public function getUfTaskWebdavFiles(): array
    {
        if (is_array($this->ufTaskWebdavFiles)) {
            return $this->ufTaskWebdavFiles;
        } else {
            return [];
        }
    }

    public function getAuditors(): array
    {
        return $this->auditors;
    }

    public function getAccomplices(): array
    {
        return $this->accomplices;
    }
}
