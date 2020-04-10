<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class DeliveryTypeEnum extends Enum
{
    const NotSet = 0;
    const OnFoot = 1;
    const Bike = 2;
    const Moto = 3;
    const Car = 4;

}
