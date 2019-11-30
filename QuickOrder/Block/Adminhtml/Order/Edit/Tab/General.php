<?php

namespace Thesis\QuickOrder\Block\Adminhtml\Order\Edit\Tab;

use Thesis\QuickOrder\Api\Model\Data\QuickOrderInterface;

class General extends AbstractTab
{
    const TAB_LABEL     = 'General';
    const TAB_TITLE     = 'General';

    /** {@inheritdoc} */
    protected function _prepareForm()
    {
        $form = $this->_formFactory->create();
        $form->setHtmlIdPrefix('order_');
        $form->setFieldNameSuffix('order');

        $fieldSet = $form->addFieldset(
            'general_fieldset',
            ['legend' => __('General')]
        );

        if ($this->model->getData(QuickOrderInterface::ID_FIELD)) {
            $fieldSet->addField(
                QuickOrderInterface::ID_FIELD,
                'hidden',
                ['name' => QuickOrderInterface::ID_FIELD]
            );
        }

        $fieldSet->addField(
            QuickOrderInterface::NAME_COL_NAME,
            'text',
            [
                'name'      => QuickOrderInterface::NAME_COL_NAME,
                'label'     => __('Name'),
                'required'  => true
            ]
        );

        $fieldSet->addField(
            QuickOrderInterface::SKU_COL_NAME,
            'text',
            [
                'name'      => QuickOrderInterface::SKU_COL_NAME,
                'label'     => __('Sku'),
                'required'  => true,
                'visible'   => false
            ]
        );

        $fieldSet->addField(
            QuickOrderInterface::PHONE_COL_NAME,
            'text',
            [
                'name'      => QuickOrderInterface::PHONE_COL_NAME,
                'label'     => __('Phone'),
                'required'  => true
            ]
        );

        $fieldSet->addField(
            QuickOrderInterface::EMAIL_COL_NAME,
            'text',
            [
                'name'      => QuickOrderInterface::EMAIL_COL_NAME,
                'label'     => __('Email'),
                'required'  => false
            ]
        );

        $fieldSet->addField(
            QuickOrderInterface::CREATED_AT_COL_NAME,
            'date',
            [
                'name'          => QuickOrderInterface::CREATED_AT_COL_NAME,
                'label'         => __('Create At'),
                'date_format'   => 'yyyy-MM-dd',
                'time_format'   => 'hh:mm:ss',
                'required'      => true
            ]
        );

        $fieldSet->addField(
            QuickOrderInterface::UPDATED_AT_COL_NAME,
            'date',
            [
                'name'          => QuickOrderInterface::UPDATED_AT_COL_NAME,
                'label'         => __('Update At'),
                'date_format'   => 'yyyy-MM-dd',
                'time_format'   => 'hh:mm:ss',
                'required'      => true
            ]
        );

        $data = $this->model->getData();

        $form->setValues($data);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
