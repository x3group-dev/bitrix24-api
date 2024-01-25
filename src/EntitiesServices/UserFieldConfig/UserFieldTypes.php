<?php

namespace Bitrix24Api\EntitiesServices\UserFieldConfig;

class UserFieldTypes
{
    /** @var string строка */
    const STRING = 'string';

    /** @var string целое число */
    const INTEGER = 'integer';

    /** @var string число */
    const DOUBLE = 'double';

    /** @var string дата */
    const DATE = 'date';

    /** @var string дата со временем */
    const DATETIME = 'datetime';

    /** @var string Да / Нет */
    const BOOLEAN = 'boolean';

    /** @var string файл */
    const FILE = 'file';

    /** @var string список */
    const ENUMERATION = 'enumeration';

    /** @var string ссылка */
    const URL = 'url';

    /** @var string адрес */
    const ADDRESS = 'address';

    /** @var string раздел инфоблока */
    const IBLOCK_SECTION = 'iblock_section';

    /** @var string элемент инфоблока */
    const IBLOCK_ELEMENT = 'iblock_element';

    /** @var string сотрудник */
    const EMPLOYEE = 'employee';

    /** @var string элемент CRM */
    const CRM = 'crm';

    /** @var string привязка к справочнику CRM */
    const CRM_STATUS = 'crm_status';
}
