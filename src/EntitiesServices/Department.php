<?php

namespace Bitrix24Api\EntitiesServices;

use Bitrix24Api\EntitiesServices\Traits\Base\DeleteTrait;
use Bitrix24Api\EntitiesServices\Traits\Base\FieldsTrait;
use Bitrix24Api\EntitiesServices\Traits\Base\GetListTrait;
use Bitrix24Api\Exceptions\ApiException;
use Bitrix24Api\Models\AbstractModel;
use Bitrix24Api\Models\DepartmentModel;

class Department extends BaseEntity
{
    use FieldsTrait, DeleteTrait;

    use GetListTrait {
        getList as protected _getListTrait;
    }

    protected string $method = 'department.%s';
    public const ITEM_CLASS = DepartmentModel::class;
    protected string $resultKey = '';
    protected string $listMethod = 'get';

    /**
     * @param $id
     * @return AbstractModel|null
     * @throws ApiException
     */
    public function get($id): ?DepartmentModel
    {
        $params = [
            'ID' => $id
        ];
        $response = $this->api->request(sprintf($this->getMethod(), 'get'), $params);

        $class = static::ITEM_CLASS;
        $entity = new $class(current($response->getResponseData()->getResult()->getResultData()));
        return !empty($response) ? $entity : null;
    }

    public function add(string $name, int $sort, int $parent, int $head): bool
    {
        try {
            $this->api->request(sprintf($this->getMethod(), 'add'), ['NAME' => $name, 'SORT' => $sort, 'PARENT' => $parent, 'HEAD' => $head]);
            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function update(int $id, string $name, int $sort, int $parent, int $head): bool
    {
        try {
            $this->api->request(sprintf($this->getMethod(), 'add'), ['ID' => $id, 'NAME' => $name, 'SORT' => $sort, 'PARENT' => $parent, 'HEAD' => $head]);
            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getList($params = []): array
    {
        $iterator = $this->_getListTrait($params);

        $result = [];

        foreach ($iterator as $item) {
            $result[] = $item;
        }

        return $result;
    }

    /**
     *  Принимает на вход массив из всех департаментов результата department.get
     *  возвращается массив поддепартаментов
     * @param array $allDepartments
     * @param int $departmentId
     * @return array
     */

    public function getAllChild(array $allDepartments, int $departmentId): array
    {
        $res = [];

        foreach ($allDepartments as $department) {
            if ($department['ID'] == $departmentId) {
                continue;
            }
            if (array_key_exists('PARENT', $department) && $department['PARENT'] == $departmentId) {
                $res[] = (int)$department['ID'];
                $departments = $this->getAllChild($allDepartments, $department['ID']);
                if (!empty($departments)) {
                    foreach ($departments as $departmentVal) {
                        $res[] = $departmentVal;
                    }
                }
            }
        }
        return $res;
    }
}
