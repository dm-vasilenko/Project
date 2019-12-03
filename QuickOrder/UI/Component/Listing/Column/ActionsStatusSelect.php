<?php

namespace Thesis\QuickOrder\UI\Component\Listing\Column;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class ActionsStatusSelect
 * @package Thesis\QuickOrder\UI\Component\Listing\Column
 */
class ActionsStatusSelect implements OptionSourceInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {

        return [
            ['value' => 1, 'label' => __('True')],
            ['value' => 0, 'label' => __('False')]
        ];
    }
}
