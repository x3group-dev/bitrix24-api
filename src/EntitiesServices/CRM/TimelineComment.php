<?php

namespace Bitrix24Api\EntitiesServices\CRM;

use Bitrix24Api\EntitiesServices\BaseEntity;
use Bitrix24Api\EntitiesServices\Traits\Base\DeleteTrait;
use Bitrix24Api\EntitiesServices\Traits\Base\FieldsTrait;
use Bitrix24Api\EntitiesServices\Traits\Base\GetListFastTrait;
use Bitrix24Api\EntitiesServices\Traits\Base\GetListTrait;
use Bitrix24Api\EntitiesServices\Traits\Base\GetTrait;
use Bitrix24Api\Models\CRM\TimelineCommentModel;

class TimelineComment extends BaseEntity
{
    use GetListTrait, GetListFastTrait, GetTrait, DeleteTrait, FieldsTrait;

    protected string $method = 'crm.timeline.comment.%s';
    public const ITEM_CLASS = TimelineCommentModel::class;
    protected string $resultKey = '';
    protected string $listMethod = 'list';

    public function add(int $entityId, string $entityType, string $comment, ?int $authorId = null, array $files = []): int
    {
        $fields = [
            'ENTITY_ID' => $entityId,
            'ENTITY_TYPE' => $entityType,
            'COMMENT' => $comment,
            'FILES' => $files,
        ];

        if ($authorId) {
            $fields['AUTHOR_ID'] = $authorId;
        }

        try {
            $response = $this->api->request(sprintf($this->getMethod(), 'add'), [
                'fields' => $fields,
            ]);
            $result = $response->getResponseData()->getResult()->getResultData();

            return current($result);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @throws \Exception
     */
    public function update(int $id, string $comment, array $files = []): bool
    {
        try {
            $this->api->request(sprintf($this->getMethod(), 'update'), [
                'id' => $id,
                'fields' => [
                    'COMMENT' => $comment,
                    'FILES' => $files,
                ],
            ]);
            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
