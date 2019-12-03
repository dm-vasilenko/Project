<?php

namespace Thesis\QuickOrder\Controller\Adminhtml\Index;

use Thesis\QuickOrder\Controller\Adminhtml\Status as BaseAction;

/**
 * Class StatusCreate
 * @package Thesis\QuickOrder\Controller\Adminhtml\Index
 */
class StatusCreate extends BaseAction
{
    const ACL_RESOURCE      = 'Thesis_QuickOrder::status';
    const PAGE_TITLE        = 'Add Status';
}
