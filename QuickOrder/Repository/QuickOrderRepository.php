<?php

namespace Thesis\QuickOrder\Repository;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;

use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Psr\Log\LoggerInterface;
use Thesis\QuickOrder\Api\Model\Data\QuickOrderInterface;
use Thesis\QuickOrder\Api\Model\Data\QuickOrderInterfaceFactory;

use Thesis\QuickOrder\Api\Model\QuickOrderRepositoryInterface;
use Thesis\QuickOrder\Model\ResourceModel\QuickOrder as ResourceModel;
use Thesis\QuickOrder\Model\ResourceModel\QuickOrder\CollectionFactory;

/**
 * Class QuickOrderRepository
 * @package Thesis\QuickOrder\Repository
 */
class QuickOrderRepository implements QuickOrderRepositoryInterface
{
    /**
     * @var ResourceModel
     */
    private $resourceModel;
    /**
     * @var QuickOrderInterfaceFactory
     */
    private $modelFactory;
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * QuickOrderRepository constructor.
     * @param ResourceModel $resourceModel
     * @param QuickOrderInterfaceFactory $quickOrderInterfaceFactory
     * @param CollectionFactory $collectionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param LoggerInterface $logger
     */
    public function __construct(
        ResourceModel $resourceModel,
        QuickOrderInterfaceFactory $quickOrderInterfaceFactory,
        CollectionFactory $collectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        LoggerInterface $logger
    ) {
        $this->resourceModel        = $resourceModel;
        $this->modelFactory         = $quickOrderInterfaceFactory;
        $this->collectionFactory    = $collectionFactory;
        $this->collectionProcessor  = $collectionProcessor;
        $this->logger               = $logger;
    }

    /**
     * @param int $id
     * @return QuickOrderInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id): QuickOrderInterface
    {
        $model = $this->modelFactory->create();

        $this->resourceModel->load($model, $id);

        if (null === $model->getId()) {
            throw new NoSuchEntityException(__('Model with %1 not found', $id));
        }

        return $model;
    }

    /**
     * @param QuickOrderInterface $quickOrder
     * @return QuickOrderRepositoryInterface
     * @throws CouldNotSaveException
     */
    public function save(QuickOrderInterface $quickOrder): QuickOrderRepositoryInterface
    {
        try {
            $this->resourceModel->save($quickOrder);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            throw new CouldNotSaveException(__("QuickOrder not saved"));
        }

        return  $this;
    }

    /**
     * @param QuickOrderInterface $quickOrder
     * @return QuickOrderRepositoryInterface
     * @throws CouldNotDeleteException
     */
    public function delete(QuickOrderInterface $quickOrder): QuickOrderRepositoryInterface
    {
        try {
            $this->resourceModel->delete($quickOrder);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            throw new CouldNotDeleteException(__("QuickOrder %1 not deleted", $quickOrder->getId()));
        }
        return  $this;
    }

    /**
     * @param int $id
     * @return QuickOrderRepositoryInterface
     * @throws CouldNotDeleteException
     */
    public function deleteById(int $id): QuickOrderRepositoryInterface
    {
        try {
            $model = $this->getById($id);
            $this->delete($model);
        } catch (NoSuchEntityException $e) {
            $this->logger->warning(sprintf("QuickOrder %d already deleted or not found", $id));
        }

        return $this;
    }
}
