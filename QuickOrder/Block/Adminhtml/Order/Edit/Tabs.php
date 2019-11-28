<?php

namespace Thesis\QuickOrder\Block\Adminhtml\Order\Edit;

use Magento\Backend\Block\Widget\Tabs as WidgetTabs;

use Thesis\QuickOrder\Block\Adminhtml\Order\Edit\Tab\General as GeneralTab;

class Tabs extends WidgetTabs
{
    /** {@inheritdoc} */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('thesis_quickorder_order_edit_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Order information'));
    }
    /**
     * @return $this
     */
    protected function _beforeToHtml()
    {
        $this->addTab(
            'general_info',
            [
                'label' => __('General'),
                'title' => __('General'),
                'content' => $this->getLayout()->createBlock(
                    GeneralTab::class
                )->toHtml(),
                'active' => true
            ]
        );

        return parent::_beforeToHtml();
    }
}
