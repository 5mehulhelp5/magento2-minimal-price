<?php
/**
 * Copyright © OpenGento, All rights reserved.
 * See LICENSE bundled with this library for license details.
 */
declare(strict_types=1);

namespace Opengento\MinimalPrice\Model\ResourceModel\Product\Indexer\Price;

use Magento\Catalog\Model\ResourceModel\Product\Indexer\Price\PriceModifierInterface;
use Magento\Catalog\Model\ResourceModel\Product\Indexer\Price\Query\JoinAttributeProcessor;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Exception\LocalizedException;
use Zend_Db;
use Zend_Db_Select_Exception;

class ApplyMinimalPrice implements PriceModifierInterface
{
    public function __construct(
        private JoinAttributeProcessor $joinAttributeProcessor,
        private ResourceConnection $resourceConnection,
        private string $connectionName = 'indexer'
    ) {}

    /**
     * @throws LocalizedException
     * @throws Zend_Db_Select_Exception
     */
    public function modifyPrice(IndexTableStructure $priceTable, array $entityIds = []): void
    {
        $connection = $this->resourceConnection->getConnection($this->connectionName);

        $select = $connection->select()->joinLeft(
            ['e' => $connection->getTableName('catalog_product_entity')],
            'e.entity_id = i.entity_id',
            ['']
        );
        if ($entityIds) {
            $select->where('i.entity_id IN (?)', $entityIds, Zend_Db::INT_TYPE);
        }

        $limitMinPriceExpr = $this->joinAttributeProcessor->process($select, 'minimal_price');
        $finalPriceExpr = $select->getConnection()->getGreatestSql([
            'i.' . $priceTable->getFinalPriceField(),
            $select->getConnection()->getIfNullSql($limitMinPriceExpr),
        ]);
        $minPriceExpr = $select->getConnection()->getGreatestSql([
            'i.' . $priceTable->getMinPriceField(),
            $select->getConnection()->getIfNullSql($limitMinPriceExpr),
        ]);

        $select->columns([
            $priceTable->getFinalPriceField() => $finalPriceExpr,
            $priceTable->getMinPriceField() => $minPriceExpr
        ]);

        $select = $connection->updateFromSelect($select, ['i' => $priceTable->getTableName()]);

        $connection->query($select);
    }
}
