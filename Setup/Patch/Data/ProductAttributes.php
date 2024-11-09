<?php
/**
 * Copyright © OpenGento, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */
declare(strict_types=1);

namespace Opengento\MinimalPrice\Setup\Patch\Data;

use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\Product\Attribute\Backend\Price;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Validator\ValidateException;

class ProductAttributes implements DataPatchInterface
{
    public function __construct(
        private ModuleDataSetupInterface $moduleDataSetup,
        private EavSetupFactory $eavSetupFactory
    ) {}

    /**
     * @throws ValidateException
     * @throws LocalizedException
     */
    public function apply(): void
    {
        $this->moduleDataSetup->startSetup();

        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);

        $eavSetup->addAttribute(Product::ENTITY, 'minimal_price', [
            'type' => 'decimal',
            'label' => 'Minimal Price',
            'input' => 'price',
            'backend' => Price::class,
            'sort_order' => 8,
            'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
            'searchable' => 0,
            'filterable' => 0,
            'visible_in_advanced_search' => 0,
            'used_in_product_listing' => 1,
            'used_for_sort_by' => 0,
            'apply_to' => 'simple,virtual',
            'group' => 'Prices',
            'required' => 0
        ]);

        $this->moduleDataSetup->endSetup();
    }

    public function getAliases(): array
    {
        return [];
    }

    public static function getDependencies(): array
    {
        return [];
    }
}
