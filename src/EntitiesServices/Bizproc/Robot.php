<?php

namespace Bitrix24Api\EntitiesServices\Bizproc;

use Bitrix24Api\EntitiesServices\BaseEntity;
use Bitrix24Api\Models\Bizproc\RobotModel;

class Robot extends BaseEntity
{
    protected string $method = 'bizproc.robot.%s';
    public const ITEM_CLASS = RobotModel::class;
    protected string $resultKey = '';
    protected string $listMethod = 'list';

    public function getList(): array
    {
        $method = sprintf($this->getMethod(), $this->listMethod);
        $result = $this->api->request(
            $method,
            []
        );

        $resultData = $result->getResponseData()->getResult()->getResultData() ?? [];

        if (!is_null($this->api->getLogger())) {
            $this->api->getLogger()->debug(
                "По запросу (getList) {$method} (получено сущностей: " . count($resultData),
            );
        }
        return $resultData;
    }

    /**
     * @throws \Exception
     */
    public function add(string $code, string $handler, int $userId, string|array $name, bool $useSubscription, array $properties, bool $usePlacement, string $placementHandler, array $returnProperties): bool
    {
        try {
            $this->api->request(sprintf($this->getMethod(), 'add'), [
                'CODE' => $code,
                'HANDLER' => $handler,
                'AUTH_USER_ID' => $userId,
                'NAME' => $name,
                'USE_SUBSCRIPTION' => $useSubscription ? 'Y' : 'N',
                'USE_PLACEMENT' => $usePlacement ? 'Y' : 'N',
                'PLACEMENT_HANDLER' => $placementHandler,
                'PROPERTIES' => $properties,
                'RETURN_PROPERTIES' => $returnProperties
            ]);
            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @throws \Exception
     */
    public function update(string $code, string $handler, int $userId, string|array $name, bool $useSubscription, array $properties, bool $usePlacement, string $placementHandler, array $returnProperties): bool
    {
        try {
            $this->api->request(sprintf($this->getMethod(), 'update'), [
                'CODE' => $code,
                'FIELDS' => [
                    'HANDLER' => $handler,
                    'AUTH_USER_ID' => $userId,
                    'NAME' => $name,
                    'USE_SUBSCRIPTION' => $useSubscription ? 'Y' : 'N',
                    'USE_PLACEMENT' => $usePlacement ? 'Y' : 'N',
                    'PLACEMENT_HANDLER' => $placementHandler,
                    'PROPERTIES' => $properties,
                    'RETURN_PROPERTIES' => $returnProperties
                ]
            ]);
            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function delete($code): bool
    {
        try {
            $this->api->request(sprintf($this->getMethod(), 'delete'), ['CODE' => $code]);
            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
