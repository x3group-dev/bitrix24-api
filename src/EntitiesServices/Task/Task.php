<?php

namespace Bitrix24Api\EntitiesServices\Task;

use Bitrix24Api\EntitiesServices\BaseEntity;
use Bitrix24Api\Exceptions\ApiException;
use Bitrix24Api\Models\AbstractModel;
use Bitrix24Api\Models\Task\TaskModel;

class Task extends BaseEntity
{
    protected string $method = 'tasks.task.%s';
    public const ITEM_CLASS = TaskModel::class;
    protected string $resultKey = 'tasks';
    protected string $listMethod = 'list';

    public function get($id, array $select = []): ?TaskModel
    {
        $class = static::ITEM_CLASS;
        try {
            $response = $this->api->request(sprintf($this->getMethod(), 'get'), ['taskId' => $id, 'select' => $select]);

            $result = $response->getResponseData()->getResult()->getResultData();
            if (isset($result['task']))
                return new $class($result['task']);
            else
                return null;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function add(array $fields = [])
    {
        try {
            $response = $this->api->request(sprintf($this->getMethod(), 'add'), ['fields' => $fields]);
            $result = $response->getResponseData()->getResult()->getResultData();
            $id = $result['task']['id'];
            if ($id > 0) {
                return $id;
            } else {
                return false;
            }
        } catch (ApiException $e) {

        }
        return false;
    }

    public function attach(int $id, int $fileId, array $params = []): ?bool
    {
        $class = static::ITEM_CLASS;
        try {
            $response = $this->api->request(sprintf($this->getMethod(), 'files.attach'), ['taskId' => $id, 'fileId' => $fileId, 'params' => $params]);
            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getAccess(int $id, array $users = [])
    {
        if (empty($users))
            return [];
        try {
            $response = $this->api->request(sprintf($this->getMethod(), 'getaccess'), ['taskId' => $id, 'users' => $users]);
            $result = $response->getResponseData()->getResult()->getResultData();
            if (isset($result['allowedActions'])) {
                return $result['allowedActions'];
            }
        } catch (ApiException $e) {

        }
    }
}
