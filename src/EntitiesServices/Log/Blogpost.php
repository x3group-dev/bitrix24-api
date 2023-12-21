<?php

namespace Bitrix24Api\EntitiesServices\Log;

use Bitrix24Api\EntitiesServices\BaseEntity;
use Bitrix24Api\Exceptions\NotImplement;
use Bitrix24Api\Models\Log\BlogpostModel;

class Blogpost extends BaseEntity
{
    protected string $method = 'log.blogpost.%s';
    public const ITEM_CLASS = BlogpostModel::class;
    protected string $resultKey = '';

    public function add(
        string $postMessage,
        int $userId = null,
        string $postTitle = null,
        array $dest = null,
        array $sperm = null,
        array $files = null,
        string $important = null,
        string $importantDateEnd = null,
    )
    {
        try {
            $this->api->request(sprintf($this->getMethod(), 'add'), [
                'USER_ID' => $userId,
                'POST_TITLE' => $postTitle,
                'POST_MESSAGE' => $postMessage,
                'DEST' => $dest,
                'SPERM' => $sperm,
                'FILES' => $files,
                'IMPORTANT' => $important,
                'IMPORTANT_DATE_END' => $importantDateEnd,
            ]);
            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

}
