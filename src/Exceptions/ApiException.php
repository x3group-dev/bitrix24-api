<?php

namespace Bitrix24Api\Exceptions;

use Exception;
use JetBrains\PhpStorm\Internal\LanguageLevelTypeAware;
use Throwable;

class ApiException extends Exception
{
    protected string $title = '';
    protected string $description = '';

    public function __construct(string $message = "", int $code = 0, string $description = '', ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->setTitle($message);
        $this->setDescription($description);
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
}