<?php
namespace Thesis\QuickOrder\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\AbstractModel;
use Psr\Log\LoggerInterface;
use Thesis\QuickOrder\Api\Model\Data\QuickOrderInterfaceFactory;
use Thesis\QuickOrder\Api\Model\Data\StatusInterfaceFactory;
use Thesis\QuickOrder\Api\Model\QuickOrderRepositoryInterface;
use Thesis\QuickOrder\Model\ResourceModel\StatusFactory;
use Thesis\QuickOrder\Model\Status;

/**
 * Class Save
 * @package Thesis\QuickOrder\Controller\Index
 */
class Save extends Action
{
    /**
     * @var QuickOrderRepositoryInterface
     */
    protected $repository;

    /**
     * @var QuickOrderInterfaceFactory
     */
    protected $orderModelFactory;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var StatusInterfaceFactory
     */
    private $statusModelFactory;

    /**
     * @var StatusFactory
     */
    protected $statusResourceFactory;

    /**
     * Save constructor.
     * @param Context $context
     * @param StatusInterfaceFactory $statusModelFactory
     * @param StatusFactory $statusResourceFactory
     * @param QuickOrderRepositoryInterface $repository
     * @param QuickOrderInterfaceFactory $orderModelFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        StatusInterfaceFactory $statusModelFactory,
        StatusFactory $statusResourceFactory,
        QuickOrderRepositoryInterface $repository,
        QuickOrderInterfaceFactory $orderModelFactory,
        LoggerInterface $logger
    ) {
        $this->statusModelFactory    =  $statusModelFactory;
        $this->statusResourceFactory =  $statusResourceFactory;
        $this->repository            =  $repository;
        $this->orderModelFactory     =  $orderModelFactory;
        $this->logger                =  $logger;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|void
     * @throws \Zend_Validate_Exception
     */
    public function execute()
    {
        $params = $this->getRequest()->getParams();

        /**
         * @var Status $statusModel
         * @var AbstractModel $orderModel
         */
        $statusModel = $this->statusModelFactory->create();

        $this->statusResourceFactory->create()->load(
            $statusModel,
            "1",
            "is_default"
        );

        try {
            $numberKey = '#^[0-9-+]+$#';
            if (!\Zend_Validate::is(trim($params['name']), 'NotEmpty')) {
                throw new LocalizedException(__('Enter the Name and try again.'));
            }
            if (!\Zend_Validate::is(trim($params['phone']), 'NotEmpty') || !preg_match($numberKey, $params['phone'])) {
                throw new LocalizedException(__('Enter the valid phone number and try again.'));
            }
            if (!\Zend_Validate::is(trim(
                $params['email']
            ), 'EmailAddress') && !empty($params['email'])) {
                throw new LocalizedException(
                    __('The email address is invalid. Verify the email address and try again.')
                );
            }

            $orderModel = $this->orderModelFactory->create();
            $orderModel->setStatus($statusModel);
            $orderModel->setName($params['name']);
            $orderModel->setSku($params['sku']);
            $orderModel->setPhone($params['phone']);
            $orderModel->setEmail($params['email']);

            $this->repository->save($orderModel);
            $this->messageManager->addSuccessMessage('Your order has been successfully accepted');
        } catch (CouldNotSaveException $e) {
            $this->logger->error($e->getMessage());
            $this->messageManager->addErrorMessage('Order failed to save');
        } catch (LocalizedException $e) {
            $this->logger->error($e->getMessage());
            $this->messageManager->addErrorMessage($e->getMessage());
        }
        $this->_redirect($params['url']);
    }
}
