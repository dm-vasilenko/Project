<?php

namespace Thesis\QuickOrder\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Thesis\QuickOrder\Api\Model\Schema\QuickOrderSchemaInterface;

/**
 * Class QuickOrder
 * @package Thesis\QuickOrder\Model\ResourceModel
 */
class QuickOrder extends AbstractDb
{

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(QuickOrderSchemaInterface::TABLE_NAME, QuickOrderSchemaInterface::ORDER_ID_COL_NAME);
    }
}
