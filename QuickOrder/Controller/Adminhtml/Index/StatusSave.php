<?php

namespace Thesis\QuickOrder\Controller\Adminhtml\Index;

use Thesis\QuickOrder\Controller\Adminhtml\Status as BaseAction;

/**
 * Class StatusSave
 * @package Thesis\QuickOrder\Controller\Adminhtml\Index
 */
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

            if (!empty($formData['status_id'])) {
                $id = $formData['status_id'];
                $model = $this->repository->getById($id);
            } else {
                unset($formData['status_id']);
            }

            $model->setData($formData);

            try {
                $this->repository->save($model);
                $this->messageManager->addSuccessMessage(__('Status has been saved.'));
                return $this->redirectToGrid();
            } catch (\Exception $e) {
                $this->logger->error($e->getMessage());
                $this->messageManager->addErrorMessage(__('Status doesn\'t save'));
            }
        }
        return $this->doRefererRedirect();
    }
}
