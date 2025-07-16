<?php

namespace App\Enums;

enum Settings: string
{
    case COMPANY_NAME = 'company_name';

    case VAT_NUMBER = 'vat_number';

    case CR_NUMBER = 'cr_number';

    case EMAIL = 'email';

    case ADDRESS = 'address';

    case PHONE = 'phone';

    case WEBSITE = 'website';

    case COMPANY_BIO = 'company_bio';

}
