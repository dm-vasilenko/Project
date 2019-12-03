<?php

namespace Thesis\QuickOrder\Api\Model\Data;

use Magento\Framework\Api\Search\SearchResultInterface;

/**
 * Interface QuickOrderSearchResultInterface
 *
 * @package Thesis\QuickOrder\Api\Model\Data
 */
interface QuickOrderSearchResultInterface extends SearchResultInterface
{
    /**
     * @param QuickOrderInterface[] $items
     * @return QuickOrderSearchResultInterface
     */
    public function setItems(array $items = null);

    /**
     * @return QuickOrderInterface[]
     */
    public function getItems();
}
