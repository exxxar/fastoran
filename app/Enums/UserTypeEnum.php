<?php

namespace App\Enums;

use Spatie\Enum\Enum;

final class UserTypeEnum extends Enum
{
    const User = 0;
    const Deliveryman = 1;
    const Admin = 2;
}
