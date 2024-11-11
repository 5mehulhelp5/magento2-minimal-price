<?php
/**
 * Copyright © OpenGento, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */
declare(strict_types=1);

namespace Opengento\MinimalPrice\Setup\Patch\Data;

use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ResourceModel\Eav\Attribute;
use Magento\Catalog\Setup\Patch\Data\InstallDefaultCategories;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Module\Manager;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Validator\ValidateException;
use Opengento\MinimalPrice\Model\Product\Attribute\Backend\MinimalPrice;

class ProductAttributesV1 implements DataPatchInterface
{
    public function __construct(
        private ModuleDataSetupInterface $moduleDataSetup,
        private EavSetupFactory $eavSetupFactory,
        private Manager $moduleManager
    ) {}

    /**
     * Create or update the minimal_price attribute
     *
     * @throws ValidateException
     * @throws LocalizedException
     */
    public function apply(): void
    {
        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $entityTypeId = $eavSetup->getEntityTypeId(Product::ENTITY);

        $applyTo = $eavSetup->getAttribute($entityTypeId, 'minimal_price', 'apply_to');
        if (!$applyTo) {
            $applyTo =  'simple,virtual';
            if ($this->moduleManager->isEnabled('Magento_Bundle')) {
                $applyTo .= ',bundle';
            }
            if ($this->moduleManager->isEnabled('Magento_Downloadable')) {
                $applyTo .= ',downloadable';
            }
        }

        $eavSetup->addAttribute($entityTypeId, 'minimal_price', [
            'type' => 'decimal',
            'label' => 'Minimal Price',
            'input' => 'price',
            'attribute_model' => Attribute::class,
            'backend' => MinimalPrice::class,
            'sort_order' => 8,
            'global' => $eavSetup->getAttribute($entityTypeId, 'minimal_price', 'is_global') ?: ScopedAttributeInterface::SCOPE_GLOBAL,
            'visible' => 1,
            'searchable' => 0,
            'filterable' => 0,
            'visible_in_advanced_search' => 0,
            'used_in_product_listing' => 1,
            'used_for_sort_by' => 0,
            'apply_to' => $applyTo,
            'group' => 'Advanced Pricing', // Originally it was names Prices
            'required' => 0,
            'is_used_in_grid' => 1,
            'is_visible_in_grid' => 0,
            'is_filterable_in_grid' => 1
        ]);
    }

    public function getAliases(): array
    {
        return [];
    }

    public static function getDependencies(): array
    {
        return [InstallDefaultCategories::class];
    }
}
