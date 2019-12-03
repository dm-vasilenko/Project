<?php

namespace Thesis\QuickOrder\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Thesis\QuickOrder\Api\Model\Schema\StatusSchemaInterface;

/**
 * Class Status
 * @package Thesis\QuickOrder\Model\ResourceModel
 */
class Status extends AbstractDb
{

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(StatusSchemaInterface::TABLE_NAME, StatusSchemaInterface::STATUS_ID_COL_NAME);
    }
}
