<?php

namespace Thesis\QuickOrder\Model\ResourceModel\Status;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Thesis\QuickOrder\Model\ResourceModel\Status as ResourceModel;
use Thesis\QuickOrder\Model\Status as Model;

/**
 * Class Collection
 * @package Thesis\QuickOrder\Model\ResourceModel\Status
 */
class Collection extends AbstractCollection
{
    /**
     * @return void
     */
    public function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
