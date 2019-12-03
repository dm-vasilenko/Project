<?php
namespace Thesis\QuickOrder\Controller\Adminhtml\Index;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Psr\Log\LoggerInterface;
use Thesis\QuickOrder\Api\Model\Data\QuickOrderInterface;
use Thesis\QuickOrder\Api\Model\Data\StatusInterfaceFactory;
use Thesis\QuickOrder\Api\Model\QuickOrderRepositoryInterface;
use Thesis\QuickOrder\Controller\Adminhtml\Order as BaseAction;
use Thesis\QuickOrder\Model\QuickOrder;
use Thesis\QuickOrder\Model\QuickOrderFactory;
use Thesis\QuickOrder\Model\ResourceModel\StatusFactory;

class Save extends BaseAction
{
    /**
     * @var StatusInterfaceFactory
     */
    protected $statusModelFactory;
    /**
     * @var StatusFactory
     */
    protected $statusResourceFactory;
    /**
     * Save constructor.
     * @param Context $context
     * @param StatusInterfaceFactory $statusModelFactory
     * @param StatusFactory $statusResourceFactory
     * @param PageFactory $pageFactory
     * @param QuickOrderRepositoryInterface $quickorderRepository
     * @param QuickOrderFactory $factory
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        StatusInterfaceFactory $statusModelFactory,
        StatusFactory $statusResourceFactory,
        PageFactory $pageFactory,
        QuickOrderRepositoryInterface $quickorderRepository,
        QuickOrderFactory $factory,
        LoggerInterface $logger
    ) {
        $this->statusModelFactory = $statusModelFactory;
        $this->statusResourceFactory = $statusResourceFactory;
        parent::__construct($context, $pageFactory, $quickorderRepository, $factory, $logger);
    }
    /** {@inheritdoc}
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        $isPost = $this->getRequest()->isPost();
        if ($isPost) {
            $model = $this->getModel();
            $formData = $this->getRequest()->getParam('order');
            if (empty($formData)) {
                $formData = $this->getRequest()->getParams();
            }
            if (!empty($formData[QuickOrderInterface::ID_FIELD])) {
                $id = $formData[QuickOrderInterface::ID_FIELD];
                $model = $this->repository->getById($id);
            } else {
                unset($formData[QuickOrderInterface::ID_FIELD]);
            }
            /**
             * @var \Thesis\QuickOrder\Model\Status $statusModel
             * @var QuickOrder $model
             */
            $statusModel = $this->statusModelFactory->create();
            $this->statusResourceFactory->create()->load($statusModel, '1', 'is_default');
            $model->setData($formData);
            $model->setStatus($statusModel);
            try {
                $this->repository->save($model);
                $this->messageManager->addSuccessMessage(__('Order has been saved.'));

                return $this->redirectToGrid();
            } catch (\Exception $e) {
                $this->logger->error($e->getMessage());
                $this->messageManager->addErrorMessage(__('Order doesn\'t save'));
            }
        }
        return $this->doRefererRedirect();
    }
}
