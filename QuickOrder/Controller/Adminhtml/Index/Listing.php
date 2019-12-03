<?php


namespace Thesis\QuickOrder\Controller\Adminhtml\Index;

use Thesis\QuickOrder\Controller\Adminhtml\Order;

/**
 * Class Listing
 * @package Thesis\QuickOrder\Controller\Adminhtml\Index
 */
class Listing extends Order
{
    const ACL_RESOURCE      = 'Thesis_QuickOrder::order';
    const PAGE_TITLE        = 'Order Grid';
}
