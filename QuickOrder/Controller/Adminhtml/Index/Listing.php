<?php


namespace Thesis\QuickOrder\Controller\Adminhtml\Index;

use Thesis\QuickOrder\Controller\Adminhtml\Order;

class Listing extends Order
{
    const ACL_RESOURCE      = 'Thesis_QuickOrder::grid';
    const MENU_ITEM         = 'Thesis_QuickOrder::grid';
    const PAGE_TITLE        = 'Order Grid';
    const BREADCRUMB_TITLE  = 'Order Grid';
}
