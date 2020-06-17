<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class FoodStatusEnum extends Enum
{
    const Unset =   0;
    const Promotion =   1;
    const InTheTop =   2;
    const BestSeller = 3;
    const NewFood = 4;
    const CustomFood = 5;
    const WeightFood = 6;
}
