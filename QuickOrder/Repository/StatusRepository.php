<?php

namespace Thesis\QuickOrder\Repository;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Data\SearchResultInterface;

use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Psr\Log\LoggerInterface;
use Thesis\QuickOrder\Api\Model\Data\StatusInterface;
use Thesis\QuickOrder\Api\Model\Data\StatusInterfaceFactory;

use Thesis\QuickOrder\Api\Model\Data\StatusSearchResultInterfaceFactory;
use Thesis\QuickOrder\Api\Model\StatusRepositoryInterface;
use Thesis\QuickOrder\Model\ResourceModel\Status as ResourceModel;
use Thesis\QuickOrder\Model\ResourceModel\Status\CollectionFactory;

/**
 * Class StatusRepository
 * @package Thesis\QuickOrder\Repository
 */
class StatusRepository implements StatusRepositoryInterface
{
    /**
     * @var ResourceModel
     */
    private $resourceModel;
    /**
     * @var StatusInterfaceFactory
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
     * @var StatusSerachResultInterfaceFactory
     */
    private $searchResultFactory;
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * StatusRepository constructor.
     * @param ResourceModel $resourceModel
     * @param StatusInterfaceFactory $statusInterfaceFactory
     * @param CollectionFactory $collectionFactory
     * @param StatusSearchResultInterfaceFactory $searchResultFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param LoggerInterface $logger
     */
    public function __construct(
        ResourceModel $resourceModel,
        StatusInterfaceFactory $statusInterfaceFactory,
        CollectionFactory $collectionFactory,
        StatusSearchResultInterfaceFactory $searchResultFactory,
        CollectionProcessorInterface $collectionProcessor,
        LoggerInterface $logger
    ) {
        $this->resourceModel        = $resourceModel;
        $this->modelFactory         = $statusInterfaceFactory;
        $this->collectionFactory    = $collectionFactory;
        $this->searchResultFactory  = $searchResultFactory;
        $this->collectionProcessor  = $collectionProcessor;
        $this->logger               = $logger;
    }
    /**
     * @param int $id
     * @return StatusInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id): StatusInterface
    {
        $model = $this->modelFactory->create();

        $this->resourceModel->load($model, $id);

        if (null === $model->getId()) {
            throw new NoSuchEntityException(__('Model with %1 not found', $id));
        }

        return $model;
    }
    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResultInterface
    {
        $collection = $this->collectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResult = $this->searchResultFactory->create();

        $searchResult->setTotalCount($collection->getSize());
        $searchResult->setSearchCriteria($searchCriteria);
        $searchResult->setItems($collection->getData());

        return $searchResult;
    }
    /**
     * @param StatusInterface $status
     * @return StatusInterface
     * @throws CouldNotSaveException
     */
    public function save(StatusInterface $status): StatusRepositoryInterface
    {
        try {
            $this->resourceModel->save($status);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            throw new CouldNotSaveException(__("Status not saved"));
        }

        return  $this;
    }
    /**
     * @param StatusInterface $status
     * @return StatusRepositoryInterface
     * @throws CouldNotDeleteException
     */
    public function delete(StatusInterface $status): StatusRepositoryInterface
    {
        try {
            $this->resourceModel->delete($status);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            throw new CouldNotDeleteException(__("Status %1 not deleted", $status->getId()));
        }
        return  $this;
    }
    /**
     * @param int $id
     * @return StatusRepositoryInterface
     * @throws CouldNotDeleteException
     */
    public function deleteById(int $id): StatusRepositoryInterface
    {
        try {
            $model = $this->getById($id);
            $this->delete($model);
        } catch (NoSuchEntityException $e) {
            $this->logger->warning(sprintf("Status %d already deleted or not found", $id));
        }

        return $this;
    }
}