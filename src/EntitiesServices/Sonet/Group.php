<?php

namespace Bitrix24Api\EntitiesServices\Sonet;

use Bitrix24Api\EntitiesServices\BaseEntity;
use Bitrix24Api\EntitiesServices\Traits\Base\GetListTrait;
use Bitrix24Api\Exceptions\ApiException;
use Bitrix24Api\Models\Sonet\GroupModel;
use DateTime;

class Group extends BaseEntity
{
    use GetListTrait;

    protected string $method = 'sonet_group.%s';
    public const ITEM_CLASS = GroupModel::class;
    protected string $resultKey = '';
    protected string $listMethod = 'get';

    public function create(
        string $name,
        string $initiatePerms,
        string $spamPerms,
        ?string $description = null,
        ?bool $visible = null,
        ?bool $opened = null,
        ?string $keywords = null,
        ?bool $closed = null,
        ?bool $project = null,
        ?DateTime $projectDateStart = null,
        ?DateTime $projectDateFinish = null,
        ?int $scrumMasterId = null,
    ): int|false
    {
        $params = [
            'NAME' => $name,
            'INITIATE_PERMS' => $initiatePerms,
            'SPAM_PERMS' => $spamPerms,
        ];

        if ($description) {
            $params['DESCRIPTION'] = $description;
        }

        if (isset($visible)) {
            $params['VISIBLE'] = $visible ? 'Y' : 'N';
        }

        if (isset($opened)) {
            $params['OPENED'] = $opened ? 'Y' : 'N';
        }

        if ($keywords) {
            $params['KEYWORDS'] = $keywords;
        }

        if (isset($closed)) {
            $params['CLOSED'] = $closed ? 'Y' : 'N';
        }

        if (isset($project)) {
            $params['PROJECT'] = $project ? 'Y' : 'N';
        }

        if ($projectDateStart) {
            $params['PROJECT_DATE_START'] = $projectDateStart->format('c');
        }

        if ($projectDateFinish) {
            $params['PROJECT_DATE_FINISH'] = $projectDateFinish->format('c');
        }

        if ($scrumMasterId) {
            $params['SCRUM_MASTER_ID'] = $scrumMasterId;
        }

        try {
            $result = $this->api->request('sonet_group.create', $params)->getResponseData()->getResult()->getResultData();

            $id = current($result);

            if ($id > 0) {
                return $id;
            }
        } catch (ApiException $e) {
            throw new ApiException($e->getMessage());
        }

        return false;
    }

    public function setOwner(int $groupId, int $userId): bool
    {
        $result = $this->api->request(sprintf($this->method, 'setowner'), [
            'GROUP_ID' => $groupId,
            'USER_ID' => $userId,
        ])->getResponseData()->getResult()->getResultData();

        return current($result);
    }
}
