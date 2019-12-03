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

use Thesis\QuickOrder\Api\Model\Data\StatusInterface;
use Thesis\QuickOrder\Api\Model\StatusRepositoryInterface;
use Thesis\QuickOrder\Model\StatusFactory;

/**
 * Class Status
 * @package Thesis\QuickOrder\Controller\Adminhtml
 */
abstract class Status extends Action
{
    const ACL_RESOURCE          = 'Thesis_QuickOrder::status';
    const PAGE_TITLE            = 'Quick Order';

    /** @var PageFactory  */
    protected $pageFactory;

    /** @var  StatusFactory */
    protected $modelFactory;

    /** @var StatusInterface */
    protected $model;

    /** @var Page */
    protected $resultPage;

    /** @var StatusRepositoryInterface */
    protected $repository;

    /** @var Logger */
    protected $logger;

    /**
     * @param Context                          $context
     * @param PageFactory                      $pageFactory
     * @param StatusRepositoryInterface        $statusRepository
     * @param StatusFactory                    $factory
     * @param LoggerInterface                  $logger
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        StatusRepositoryInterface $statusRepository,
        StatusFactory $factory,
        LoggerInterface $logger
    ) {
        $this->pageFactory    = $pageFactory;
        $this->repository     = $statusRepository;
        $this->modelFactory   = $factory;
        $this->logger         = $logger;

        parent::__construct($context);
    }

    /** {@inheritdoc} */
    public function execute()
    {
        $this->_setPageData();

        return $this->resultPage;
    }

    /** {@inheritdoc} */
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
     * @return Status
     */
    protected function _setPageData()
    {
        $resultPage = $this->_getResultPage();
        $resultPage->getConfig()->getTitle()->prepend((__(static::PAGE_TITLE)));
        return $this;
    }

    /** @return StatusInterface */
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
        return $this->_redirect('*/*/statuslisting');
    }
}
