<?php

namespace Thesis\QuickOrder\Controller\Adminhtml\Index;

use Thesis\QuickOrder\Api\Model\Data\StatusInterface;
use Thesis\QuickOrder\Controller\Adminhtml\Status as BaseAction;

/**
 * Class StatusCreate
 * @package Thesis\QuickOrder\Controller\Adminhtml\Index
 */
class StatusCreate extends BaseAction
{
    const ACL_RESOURCE      = 'Thesis_QuickOrder::all';
    const MENU_ITEM         = 'Thesis_QuickOrder::all';
    const PAGE_TITLE        = 'Add Status';
    const BREADCRUMB_TITLE  = 'Add Status';
}
