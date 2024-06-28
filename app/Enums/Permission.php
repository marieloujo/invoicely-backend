<?php

namespace App\Enums;

enum Permission: string {

    case MANAGE_SERVICE = "manage-service";

    case MANAGE_PRODUCT = "manage-product";

}