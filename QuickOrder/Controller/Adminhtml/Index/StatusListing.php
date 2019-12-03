<?php

namespace Thesis\QuickOrder\Controller\Adminhtml\Index;

use Thesis\QuickOrder\Controller\Adminhtml\Status;

/**
 * Class StatusListing
 * @package Thesis\QuickOrder\Controller\Adminhtml\Index
 */
class StatusListing extends Status
{
    const ACL_RESOURCE      = 'Thesis_QuickOrder::status';
    const PAGE_TITLE        = 'Status Grid';
}
