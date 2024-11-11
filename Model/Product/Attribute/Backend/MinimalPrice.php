<?php
/**
 * Copyright © OpenGento, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */
declare(strict_types=1);

namespace Opengento\MinimalPrice\Model\Product\Attribute\Backend;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Model\Product\Attribute\Backend\Price;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Phrase;

class MinimalPrice extends Price
{
    public function validate($object): bool
    {
        if (parent::validate($object)) {
            $attribute = $this->getAttribute();
            if ($object->getData(ProductInterface::PRICE) < $object->getData($attribute->getAttributeCode())) {
                throw new LocalizedException(
                    new Phrase('%1 must be lower than the price.', [$attribute->getDefaultFrontendLabel()])
                );
            }
        }

        return true;
    }
}
