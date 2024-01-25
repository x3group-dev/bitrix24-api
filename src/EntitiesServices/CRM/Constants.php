<?php

namespace Bitrix24Api\EntitiesServices\CRM;

use Bitrix24Api\EntitiesServices\CRM\Enums\Constants as Enum;

class Constants
{
    public function lead(): Enum
    {
        return Enum::CrmLead;
    }

    public function deal(): Enum
    {
        return Enum::CrmDeal;
    }

    public function contact(): Enum
    {
        return Enum::CrmContact;
    }

    public function company(): Enum
    {
        return Enum::CrmCompany;
    }

    public function invoice(): Enum
    {
        return Enum::CrmInvoice;
    }

    public function smartInvoice(): Enum
    {
        return Enum::CrmSmartInvoice;
    }

    public function quote(): Enum
    {
        return Enum::CrmQuote;
    }

    public function requisite(): Enum
    {
        return Enum::CrmRequisite;
    }
}
