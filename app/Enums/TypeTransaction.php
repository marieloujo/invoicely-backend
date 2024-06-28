<?php

namespace App\Enums;

enum TypeTransaction: string
{

    use BaseEnum;

    case STORAGE = 'STORAGE';

    case SALES = 'SALES';

    case DESTOCKING = 'DESTOCKING';

}
