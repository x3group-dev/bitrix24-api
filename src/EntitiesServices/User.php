<?php

namespace Bitrix24Api\EntitiesServices;

use Bitrix24Api\EntitiesServices\Traits\Base\GetListFastTrait;
use Bitrix24Api\EntitiesServices\Traits\Base\GetListTrait;
use Bitrix24Api\Exceptions\ApiException;
use Bitrix24Api\Models\AbstractModel;
use Bitrix24Api\Models\User\UserModel;

class User extends BaseEntity
{
    use GetListTrait, GetListFastTrait;

    protected string $method = 'user.%s';
    public const ITEM_CLASS = UserModel::class;
    protected string $resultKey = '';
    protected string $listMethod = 'get';

    /**
     * @param $id
     * @return AbstractModel|null
     * @throws ApiException
     */
    public function get($id): ?UserModel
    {
        $params = [
            'FILTER' => [
                'ID' => $id
            ]
        ];
        $response = $this->api->request(sprintf($this->getMethod(), 'get'), $params);

        $class = static::ITEM_CLASS;
        $entity = new $class(current($response->getResponseData()->getResult()->getResultData()));
        return !empty($response) ? $entity : null;
    }

    /**
     * @param $access
     * @return bool
     * @throws ApiException
     */
    public function access($access = []): bool
    {
        $params = [
            'ACCESS' => $access
        ];
        return current($this->api->request(sprintf($this->getMethod(), 'access'), $params)->getResponseData()->getResult()->getResultData());
    }

    /**
     * Обрабатывает массив $data формата BX24.selectAccess и возвращает список ID сотрудников
     * @param array $data
     * @param bool $active
     * @param bool $adminMode
     * @return array
     * @throws \Exception
     */
    public function getSelectedUserData(array $data, bool $active = true, bool $adminMode = true): array
    {
        $users = [];

        $departmentSearchId = [];
        $departmentUserBatch = $this->api->batch();
        $sonetSearchId = [];
        $sonetUserBatch = $this->api->batch();
        foreach ($data as $item) {
            if (str_contains($item['id'], 'IU')) {
                $users[] = (int)str_replace('IU', '', $item['id']);
            }

            if (str_contains($item['id'], 'UI')) {
                $users[] = (int)str_replace('UI', '', $item['id']);
            }

            if (str_contains($item['id'], 'U') && !str_contains($item['id'], 'I')) {
                $users[] = (int)str_replace('U', '', $item['id']);
            }
            if (str_contains($item['id'], 'D') && !str_contains($item['id'], 'R')) {
                if (!in_array($item['id'], $departmentSearchId)) {
                    $departmentUserBatch->addCommand('user.get', ['ADMIN_MODE' => $adminMode, 'FILTER' => ['UF_DEPARTMENT' => str_replace('D', '', $item['id']), 'ACTIVE' => $active ? 'Y' : 'N']], $item['id']);
                    $departmentSearchId[] = $item['id'];
                }
            }

            if (str_contains($item['id'], 'DR')) {
                //todo: optimize
                $users = array_merge($users, $this->getAllDepartmentUsersWithSubdivisions(str_replace('DR', '', $item['id']), $active, $adminMode));
            }

            if (str_contains($item['id'], 'SG')) {
                $sg = explode('_', $item['id']);
                $sonetGroupId = str_replace('SG', '', current($sg));
                if (!in_array($sonetGroupId, $sonetSearchId)) {
                    $sonetUserBatch->addCommand('sonet_group.user.get', ['ID' => $sonetGroupId], $item['id']);
                    $sonetSearchId[] = $sonetGroupId;
                }
            }
        }

        // D
        foreach ($departmentUserBatch->getTraversable() as $departmentUsers) {
            foreach ($departmentUsers->getResult()->getResultData() as $departmentUser) {
                $users[] = $departmentUser['ID'];
            }
        }

        // SG
        foreach ($sonetUserBatch->getTraversable() as $sonetUsers) {
            $command = $sonetUsers->getCommand()->getName();
            $sg = explode('_', $command);
            $sonetSearchMode = null;
            if (isset($sg[1])) {
                $sonetSearchMode = $sg[1];
            }

            foreach ($sonetUsers->getResult()->getResultData() as $sonetUser) {
                if ($sonetSearchMode && $sonetUser['ROLE'] == $sonetSearchMode) {
                    $users[] = $sonetUser['USER_ID'];
                } elseif (is_null($sonetSearchMode)) {
                    $users[] = $sonetUser['USER_ID'];
                }
            }
        }

        return array_unique($users);
    }

    /**
     * Получить список ID всех сотрудников отдела и подотделов
     * @param int $departmentId
     * @param bool $active
     * @param bool $adminMode
     * @return array
     * @throws ApiException
     */
    public function getAllDepartmentUsersWithSubdivisions(int $departmentId, bool $active = true, bool $adminMode = true): array
    {
        $allDepartments = $this->api->request('department.get')->getResponseData()->getResult()->getResultData();
        $users = [];
        $childDepartments = $this->getAllChildDepartments($allDepartments, $departmentId);
        $departments = array_merge([$departmentId], $childDepartments);

        $batchSettings = $this->api->batch();
        foreach ($departments as $department) {
            $batchSettings->addCommand('user.get', ['ADMIN_MODE' => $adminMode, 'FILTER' => ['UF_DEPARTMENT' => $department, 'ACTIVE' => $active ? 'Y' : 'N']]);
        }

        foreach ($batchSettings->getTraversable() as $item) {
            if (current($item->getResult()->getResultData()) != false) {
                $res = $item->getResult()->getResultData();
                foreach ($res as $user) {
                    $users[] = (int)$user['ID'];
                }
            }
        }

        return array_unique($users);
    }

    /**
     * @param array $allDepartments
     * @param int $departmentId
     * @return array
     * @deprecated
     * moved to Department
     *  Принимает на вход массив из всех департаментов результата department.get
     *  возвращается массив поддепартаментов
     */
    private function getAllChildDepartments(array $allDepartments, int $departmentId): array
    {
        return $this->api->department()->getAllChild($allDepartments, $departmentId);
    }
}
