<?php

namespace Thesis\QuickOrder\Block\Adminhtml\Order;

use Magento\Backend\Block\Widget\Context;
use Magento\Backend\Block\Widget\Form\Container;
use Magento\Framework\Registry;
use Thesis\QuickOrder\Api\Model\Data\QuickOrderInterface;

class Edit extends Container
{
    /** @var Registry */
    protected $registry;

    /** @var string */
    private $headerText;
    /**
     * Edit constructor.
     * @param Context   $context
     * @param Registry  $registry
     * @param array     $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        array $data = []
    ) {
        $this->registry = $registry;
        parent::__construct($context, $data);
    }

    /** {@inheritdoc} */
    protected function _construct()
    {
        $this->_objectId   = 'id';
        $this->_controller = 'adminhtml_order';
        $this->_blockGroup = 'Thesis_QuickOrder';

        parent::_construct();

        $this->addButton(
            'back',
            [
                'label' => __('Back to orders'),
                'onclick' => 'setLocation(\'' . $this->getUrl('*/*/*') . '\')',
                'class' => 'back'
            ],
            -1
        );

    }

    /** {@inheritdoc} */
    public function getHeaderText()
    {
        $model = $this->registry->registry(QuickOrderInterface::REGISTRY_KEY);
        if ($model->getId()) {
            $this->headerText = __("Edit item '%1'", $model->getId());
        } else {
            $this->headerText = __('Create new item');
        }

        return $this->headerText;
    }

    /** {@inheritdoc} */
    protected function _prepareLayout()
    {
        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('post_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'post_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'post_content');
                }
            };
        ";

        return parent::_prepareLayout();
    }
}
