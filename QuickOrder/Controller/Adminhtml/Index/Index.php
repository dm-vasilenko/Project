<?php

namespace Thesis\QuickOrder\Controller\Adminhtml\Index;

use Thesis\QuickOrder\Controller\Adminhtml\Order as BaseAction;

/**
 * Class Index
 * @package Thesis\QuickOrder\Controller\Adminhtml\Index
 */
class Index extends BaseAction
{
    const ACL_RESOURCE      = 'Thesis_QuickOrder::all';
    const PAGE_TITLE        = 'Order Grid';
}
