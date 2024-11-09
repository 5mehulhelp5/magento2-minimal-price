<?php
/**
 * Copyright © OpenGento, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */
declare(strict_types=1);

namespace Opengento\MinimalPrice\Plugin\Pricing\Price;

use Magento\Catalog\Pricing\Price\FinalPrice;

use function max;

class ApplyMinimalPrice
{
    public function afterGetValue(FinalPrice $subject, float $result): float
    {
        return max((float)$subject->getProduct()->getMinimalPrice(), $result);
    }
}
