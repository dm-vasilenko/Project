<?php

namespace Thesis\QuickOrder\Block\Adminhtml\Status\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class SaveStatus
 *
 * @package Thesis\QuickOrder\Block\Adminhtml\Status\Edit
 */
class SaveStatus extends StatusButton implements ButtonProviderInterface
{
    /**
     * {@inheritdoc} 
     */
    public function getButtonData()
    {
        return [
            'label' => __('Save Status'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save',
            ],
            'sort_order' => 90,
        ];
    }
}