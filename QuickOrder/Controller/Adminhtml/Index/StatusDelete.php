<?php

namespace Thesis\QuickOrder\Controller\Adminhtml\Index;

use Thesis\QuickOrder\Controller\Adminhtml\Status as BaseAction;

/**
 * Class StatusDelete
 * @package Thesis\QuickOrder\Controller\Adminhtml\Index
 */
class StatusDelete extends BaseAction
{
    /** {@inheritdoc} */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $default = $this->getRequest()->getParam('default');

        if (!empty($id) && ($default == "0")) {
            try {
                $this->repository->deleteById($id);
                $this->messageManager->addSuccessMessage(__('Status has been deleted.'));
            } catch (\Exception $e) {
                $this->logger->error($e->getMessage());
                $this->messageManager->addErrorMessage(_('status can\'t delete'));
                return $this->doRefererRedirect();
            }
        } else {
            $this->logger->error(
                sprintf("Require parameter `%s` is missing", 'id')
            );
            $this->messageManager->addErrorMessage(_('status is default'));
            return $this->doRefererRedirect();
        }

        return $this->redirectToGrid();
    }
}
