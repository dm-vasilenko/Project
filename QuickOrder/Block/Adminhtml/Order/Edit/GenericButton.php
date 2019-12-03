<?php

namespace Thesis\QuickOrder\Block\Adminhtml\Order\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;

use Psr\Log\LoggerInterface;
use Thesis\QuickOrder\Api\Model\QuickOrderRepositoryInterface;

/**
 * Class GenericButton
 * @package Thesis\QuickOrder\Block\Adminhtml\Order\Edit
 */
class GenericButton
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var Context
     */
    protected $context;

    /**
     * @var QuickOrderRepositoryInterface
     */
    protected $repository;

    /**
     * GenericButton constructor.
     *
     * @param Context                       $context
     * @param QuickOrderRepositoryInterface $repository
     */
    public function __construct(
        Context $context,
        QuickOrderRepositoryInterface $repository,
        LoggerInterface $logger
    ) {
        $this->context      = $context;
        $this->repository   = $repository;
        $this->logger       = $logger;
    }

    /**
     * Return Order ID
     *
     * @return int|null
     */
    public function getOrderId()
    {
        try {
            return $this->repository->getById(
                $this->context->getRequest()->getParam('id')
            )->getId();
        } catch (NoSuchEntityException $e) {
            $this->logger->error($e->getMessage());
        }
        return null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param  string $route
     * @param  array  $params
     * @return string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
