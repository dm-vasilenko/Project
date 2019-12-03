<?php

namespace Thesis\QuickOrder\Controller\Adminhtml;

use Magento\Backend\App\Action;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use Psr\Log\LoggerInterface;

use Thesis\QuickOrder\Api\Model\Data\QuickOrderInterface;
use Thesis\QuickOrder\Api\Model\QuickOrderRepositoryInterface;
use Thesis\QuickOrder\Model\QuickOrderFactory;

/**
 * Class Order
 * @package Thesis\QuickOrder\Controller\Adminhtml
 */
abstract class Order extends Action
{
    const ACL_RESOURCE          = 'Thesis_QuickOrder::order';
    const PAGE_TITLE            = 'Quick Order';

    /**
     * @var PageFactory
     */
    protected $pageFactory;

    /**
     * @var QuickOrderFactory
     */
    protected $modelFactory;

    /**
     * @var QuickOrderInterface
     */
    protected $model;

    /**
     * @var Page
     */
    protected $resultPage;

    /**
     * @var QuickOrderRepositoryInterface
     */
    protected $repository;

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @param Context                       $context
     * @param PageFactory                   $pageFactory
     * @param QuickOrderRepositoryInterface $quickorderRepository
     * @param QuickOrderFactory             $factory
     * @param LoggerInterface               $logger
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        QuickOrderRepositoryInterface $quickorderRepository,
        QuickOrderFactory $factory,
        LoggerInterface $logger
    ) {
        $this->pageFactory    = $pageFactory;
        $this->repository     = $quickorderRepository;
        $this->modelFactory   = $factory;
        $this->logger         = $logger;

        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $this->_setPageData();

        return $this->resultPage;
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        $result = parent::_isAllowed();
        $result = $result && $this->_authorization->isAllowed(static::ACL_RESOURCE);

        return $result;
    }

    /**
     * @return Page
     */
    protected function _getResultPage()
    {
        if (null === $this->resultPage) {
            $this->resultPage = $this->pageFactory->create();
        }

        return $this->resultPage;
    }

    /**
     * @return Order
     */
    protected function _setPageData()
    {
        $resultPage = $this->_getResultPage();
        $resultPage->getConfig()->getTitle()->prepend((__(static::PAGE_TITLE)));
        return $this;
    }

    /**
     * @return QuickOrderInterface
     */
    protected function getModel()
    {
        if (null === $this->model) {
            $this->model = $this->modelFactory->create();
        }

        return $this->model;
    }

    /**
     * @return ResultInterface
     */
    protected function doRefererRedirect()
    {
        $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $redirect->setUrl($this->_redirect->getRefererUrl());

        return $redirect;
    }

    /**
     * @return ResponseInterface
     */
    protected function redirectToGrid()
    {
        return $this->_redirect('*/*/listing');
    }
}
