Проверка на существование хранилища и создание в случае отсутствия
```injectablephp
$entity = $api->entity('SOME_ENTITY_ID');
try {
    $entity->get();
} catch (NotFound $exception) {
    $entity->add('Название хранилища');
} catch (\Exception $exception) {

}
```
