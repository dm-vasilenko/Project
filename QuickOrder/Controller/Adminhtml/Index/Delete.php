<?php

namespace Thesis\QuickOrder\Controller\Adminhtml\Index;

use Thesis\QuickOrder\Controller\Adminhtml\Order as BaseAction;

/**
 * Class Delete
 * @package Thesis\QuickOrder\Controller\Adminhtml\Index
 */
class Delete extends BaseAction
{
    /** {@inheritdoc} */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');

        if (!empty($id)) {
            try {
                $this->repository->deleteById($id);
                $this->messageManager->addSuccessMessage(__('Order has been deleted.'));
            } catch (\Exception $e) {
                $this->logger->error($e->getMessage());
                $this->messageManager->addErrorMessage(_('order can\'t delete'));
                return $this->doRefererRedirect();
            }
        } else {
            $this->logger->error(
                sprintf("Require parameter `%s` is missing", 'id')
            );
            $this->messageManager->addMessage(__('No item to delete'));
        }

        return $this->redirectToGrid();
    }
}
