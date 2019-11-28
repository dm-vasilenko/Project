<?php

namespace Thesis\QuickOrder\Block\Adminhtml\Status\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class SaveStatus extends StatusButton implements ButtonProviderInterface
{
    /** {@inheritdoc} */
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