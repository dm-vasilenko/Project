<?php

namespace Thesis\QuickOrder\Controller\Adminhtml\Index;

use Thesis\QuickOrder\Api\Model\Data\QuickOrderInterface;
use Thesis\QuickOrder\Controller\Adminhtml\Order as BaseAction;

/**
 * Class Create
 * @package Thesis\QuickOrder\Controller\Adminhtml\Index
 */
class Create extends BaseAction
{
    const ACL_RESOURCE      = 'Thesis_QuickOrder::all';
    const MENU_ITEM         = 'Thesis_QuickOrder::all';
    const PAGE_TITLE        = 'Add Order';
    const BREADCRUMB_TITLE  = 'Add Order';
}
