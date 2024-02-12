<?php

namespace Bitrix24Api\EntitiesServices\CRM\Enums;

enum Constants
{
    case CrmLead;
    case CrmDeal;
    case CrmContact;
    case CrmCompany;
    case CrmInvoice;
    case CrmSmartInvoice;
    case CrmQuote;
    case CrmRequisite;

    public function entityTypeId(): int
    {
        return match ($this) {
            Constants::CrmLead => 1,
            Constants::CrmDeal => 2,
            Constants::CrmContact => 3,
            Constants::CrmCompany => 4,
            Constants::CrmInvoice => 5,
            Constants::CrmSmartInvoice => 31,
            Constants::CrmQuote => 7,
            Constants::CrmRequisite => 8,
        };
    }

    public function entityId(): string
    {
        return match ($this) {
            Constants::CrmLead => 'CRM_LEAD',
            Constants::CrmDeal => 'CRM_DEAL',
            Constants::CrmContact => 'CRM_CONTACT',
            Constants::CrmCompany => 'CRM_COMPANY',
            Constants::CrmInvoice => 'CRM_INVOICE',
            Constants::CrmSmartInvoice => 'CRM_SMART_INVOICE',
            Constants::CrmQuote => 'CRM_QUOTE',
            Constants::CrmRequisite => 'CRM_REQUISITE',
        };
    }

    public function entityTypeName(): string
    {
        return match ($this) {
            Constants::CrmLead => 'LEAD',
            Constants::CrmDeal => 'DEAL',
            Constants::CrmContact => 'CONTACT',
            Constants::CrmCompany => 'COMPANY',
            Constants::CrmInvoice => 'INVOICE',
            Constants::CrmSmartInvoice => 'SMART_INVOICE',
            Constants::CrmQuote => 'QUOTE',
            Constants::CrmRequisite => 'REQUISITE',
        };
    }

    public function shortCode(): string
    {
        return match ($this) {
            Constants::CrmLead => 'L',
            Constants::CrmDeal => 'D',
            Constants::CrmContact => 'C',
            Constants::CrmCompany => 'CO',
            Constants::CrmInvoice => 'I',
            Constants::CrmSmartInvoice => 'SI',
            Constants::CrmQuote => 'Q',
            Constants::CrmRequisite => 'RQ',
        };
    }
}
