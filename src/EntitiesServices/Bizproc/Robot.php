<?php

namespace Bitrix24Api\EntitiesServices\Bizproc;

use Bitrix24Api\EntitiesServices\BaseEntity;
use Bitrix24Api\EntitiesServices\Traits\Base\GetListArrayTrait;
use Bitrix24Api\Models\Bizproc\RobotModel;

class Robot extends BaseEntity
{
    use GetListArrayTrait;
    protected string $method = 'bizproc.robot.%s';
    public const ITEM_CLASS = RobotModel::class;
    protected string $resultKey = '';
    protected string $listMethod = 'list';

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
            $fields = [
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
            ];
            if(empty($placementHandler))
                unset($fields['FIELDS']['PLACEMENT_HANDLER']);

            $this->api->request(sprintf($this->getMethod(), 'update'), $fields);
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
