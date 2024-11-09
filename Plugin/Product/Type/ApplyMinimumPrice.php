<?php
/**
 * Copyright © OpenGento, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */
declare(strict_types=1);

namespace Opengento\MinimalPrice\Plugin\Product\Type;

use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\Product\Type\Price;

use function max;

class ApplyMinimalPrice
{
    public function afterGetFinalPrice(Price $subject, float $result, ?float $qty, Product $product): float
    {
        return max($product->getMinimalPrice() * max(1, $qty), $result);
    }
}
