<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class OrderStatusEnum extends Enum
{
    const InProcessing = 0;
    const GettingReady = 1;
    const InDeliveryProcess = 2;
    const Delivered = 3;
    const DeclineByAdmin = 4;
    const InQueue = 5;
}
