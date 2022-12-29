```injectablephp
    $crmSmartItemList = $api->crmSmartItem(['entityTypeId' => 128]);
    $list = $crmSmartItemList->getList(['filter'=>['title'=>'111%']]);
    foreach ($list as $item) {
        echo '<pre>';
        print_r($item->toArray());
        echo '</pre>';
    }
```

Без подсчета количества элементов (быстрое получение)
```injectablephp
    $crmSmartItemList = $api->crmSmartItem(['entityTypeId' => 128]);
    $list = $crmSmartItemList->getListFast(['filter'=>['title'=>'111%']]);
    foreach ($list as $item) {
        echo '<pre>';
        print_r($item->toArray());
        echo '</pre>';
    }
```