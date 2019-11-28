<?php
namespace Thesis\QuickOrder\UI\Component\Listing\Column;



class ActionsSelect implements \Magento\Framework\Option\ArrayInterface
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
