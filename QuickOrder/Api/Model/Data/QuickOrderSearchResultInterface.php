<?php

namespace Thesis\QuickOrder\Api\Model\Data;

use Magento\Framework\Api\Search\SearchResultInterface;

interface QuickOrderSearchResultInterface extends SearchResultInterface
{
    /**
     * Set blocks list.
     *
     * @param QuickOrderInterface[] $items
     * @return QuickOrderSearchResultInterface
     */
    public function setItems(array $items = null);

    /**
     * Get order list.
     *
     * @return QuickOrderInterface[]
     */
    public function getItems();


}
