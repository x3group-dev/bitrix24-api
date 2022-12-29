<?php

namespace Bitrix24Api\Batch;

class CommandCollection extends \SplObjectStorage
{
    private function filter(callable $filterCallback = null)
    {
        $filteredCollection = new static;
        foreach ($this as $item) {
            $itemData = null;
            if ($this->offsetExists($item)) {
                $itemData = $this->offsetGet($item);
            }
            if ($filterCallback !== null && call_user_func_array($filterCallback, [$item, $itemData]) !== true) {
                continue;
            }
            $filteredCollection->attach($item, $itemData);
        }
        $filteredCollection->rewind();

        return $filteredCollection;
    }


    public function getByName(string $name): Command
    {
        $filtered = $this->filter(
            static function (Command $item) use ($name) {
                return $item->getName() === $name;
            }
        );

        if ($filtered->count() === 1) {
            $filtered->rewind();

            return $filtered->current();
        }

        throw new \Exception(sprintf('command by name %s not found', $name));
    }
}
