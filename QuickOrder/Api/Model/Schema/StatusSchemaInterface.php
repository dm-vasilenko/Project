<?php

namespace Thesis\QuickOrder\Api\Model\Schema;

/**
 * Interface StatusSchemaInterface
 *
 * @package Thesis\QuickOrder\Api\Model\Schema
 */
interface StatusSchemaInterface
{
    const TABLE_NAME            = 'quick_order_status';
    const STATUS_ID_COL_NAME    = 'status_id';
    const STATUS_CODE_COL_NAME  = 'status_code';
    const STATUS_LABEL_COL_NAME = 'label';
    const IS_DEFAULT            = 'is_default';
}
