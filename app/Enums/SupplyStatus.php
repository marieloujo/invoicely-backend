<?php

namespace App\Enums;

enum SupplyStatus: string
{

    use BaseEnum;

    case PENDING = 'PENDING';

    case VALIDATED = 'VALIDATED';

    case NON_COMPLIANCE = 'NON_COMPLIANCE';

}
