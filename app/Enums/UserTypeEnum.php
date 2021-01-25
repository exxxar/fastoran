<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class UserTypeEnum extends Enum
{
    const User = 0;
    const Deliveryman = 1;
    const Admin = 2;
    const SuperAdmin = 3;
}
