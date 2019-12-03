<?php

namespace Thesis\QuickOrder\Block\Adminhtml\Status\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;

use Psr\Log\LoggerInterface;
use Thesis\QuickOrder\Api\Model\StatusRepositoryInterface;

/**
 * Class StatusButton
 * @package Thesis\QuickOrder\Block\Adminhtml\Status\Edit
 */
class StatusButton
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
     * @var StatusRepositoryInterface
     */
    protected $repository;

    /**
     * StatusButton constructor.
     *
     * @param Context $context
     * @param StatusRepositoryInterface $repository
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        StatusRepositoryInterface $repository,
        LoggerInterface $logger
    ) {
        $this->context      = $context;
        $this->repository   = $repository;
        $this->logger       = $logger;
    }

    /**
     * Return Status ID
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
