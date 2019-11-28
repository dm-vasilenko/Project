<?php

namespace Thesis\QuickOrder\Controller\Adminhtml\Index;

use Thesis\QuickOrder\Api\Model\Data\StatusInterface;
use Thesis\QuickOrder\Controller\Adminhtml\Status as BaseAction;

class StatusSave extends BaseAction
{
    /** {@inheritdoc} */
    public function execute()
    {
        $isPost = $this->getRequest()->isPost();

        if ($isPost) {
            $model = $this->getModel();
            $formData = $this->getRequest()->getParam('status');

            if (empty($formData)) {
                $formData = $this->getRequest()->getParams();
            }

            if (!empty($formData[StatusInterface::ID_FIELD])) {
                $id = $formData[StatusInterface::ID_FIELD];
                $model = $this->repository->getById($id);
            } else {
                unset($formData[StatusInterface::ID_FIELD]);
            }

            $model->setData($formData);

            try {
                $model = $this->repository->save($model);
                $this->messageManager->addSuccessMessage(__('Status has been saved.'));
                if ($this->getRequest()->getParam('back')) {
                    return $this->_redirect('*/*/statusedit', ['id' => $model->getId(), '_current' => true]);
                }

                return $this->redirectToGrid();
            } catch (\Exception $e) {
                $this->logger->error($e->getMessage());
                $this->messageManager->addErrorMessage(__('Status doesn\'t save'));
            }

            $this->_getSession()->setFormData($formData);

            return (!empty($model->getId())) ?
                $this->_redirect('*/*/statusedit', ['id' => $model->getId()])
                : $this->_redirect('*/*/statuscreate');
        }

        return $this->doRefererRedirect();
    }
}
