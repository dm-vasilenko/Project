<?php

namespace Thesis\QuickOrder\Model\ResourceModel\Status;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Thesis\QuickOrder\Model\ResourceModel\Status as ResourceModel;
use Thesis\QuickOrder\Model\Status as Model;

class Collection extends AbstractCollection
{
    public function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
