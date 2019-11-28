<?php

namespace Thesis\QuickOrder\Controller\Adminhtml\Index;

use Magento\Framework\Exception\NoSuchEntityException;

use Thesis\QuickOrder\Api\Model\Data\StatusInterface;
use Thesis\QuickOrder\Controller\Adminhtml\Status as BaseAction;

class StatusEdit extends BaseAction
{
    const ACL_RESOURCE      = 'Thesis_QuickOrder::all';
    const MENU_ITEM         = 'Thesis_QuickOrder::all';
    const PAGE_TITLE        = 'Edit status';
    const BREADCRUMB_TITLE  = 'Edit status';

    /** {@inheritdoc} */
    public function execute()
    {
        $id = $this->getRequest()->getParam(static::QUERY_PARAM_ID);

        if (!empty($id)) {
            try {
                $model = $this->repository->getById($id);
            } catch (NoSuchEntityException $exception) {
                $this->logger->error($exception->getMessage());
                $this->messageManager->addErrorMessage(__('Entity with id %1 not found', $id));
                return $this->redirectToGrid();
            }

        } else {
            $this->logger->error(
                sprintf("Require parameter `%s` is missing", static::QUERY_PARAM_ID)
            );
            $this->messageManager->addErrorMessage("status not found");
            return $this->redirectToGrid();
        }

        $data = $this->_session->getFormData(true);

        if (!empty($data)) {
            $model->setData($data);
        }

        $this->registry->register(StatusInterface::REGISTRY_KEY, $model);

        return parent::execute();
    }
}
