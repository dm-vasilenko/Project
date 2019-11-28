<?php

namespace Thesis\QuickOrder\Controller\Adminhtml\Index;

use Thesis\QuickOrder\Controller\Adminhtml\Status as BaseAction;

class StatusMassDelete extends BaseAction
{
    /** {@inheritdoc} */
    public function execute()
    {
        $statusDeletedQuo = 0;

        $ids = $this->getRequest()->getParam('selected');
        if (count($ids)) {
            foreach ($ids as $id) {
                try {
                    if ($this->repository->getById($id)->getData('is_default')) {
                        throw new \Exception();
                    }
                    $this->repository->deleteById($id);
                    $statusDeletedQuo++;
                } catch (\Exception $e) {
                    $this->logger->error($e->getMessage());
                    $this->logger->critical(
                        sprintf("Can\'t delete status: %d", $id)
                    );
                    $this->messageManager->addErrorMessage(__('Status with id %1 not deleted', $id));
                }
            }
            $this->messageManager->addSuccessMessage(
                __('A total of %1 record(s) has been deleted.', $statusDeletedQuo)
            );
        } else {
            $this->logger->error("Parameter ids must be array and not empty");
            $this->messageManager->addWarningMessage("Please select items to delete");
        }

        return $this->redirectToGrid();
    }
}
