<?php

namespace Thesis\QuickOrder\Api\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Data\SearchResultInterface;
use Thesis\QuickOrder\Api\Model\Data\QuickOrderInterface;

interface QuickOrderRepositoryInterface
{
    /**
     * @param int $id
     * @return QuickOrderInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(int $id);

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultInterface
     */

    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * @param QuickOrderInterface $quickorder
     * @return QuickOrderInterface
     */

    public function save(QuickOrderInterface $quickorder);

    /**
     * @param QuickOrderInterface $quickOrder
     * @return QuickOrderRepositoryInterface
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */

    public function delete(QuickOrderInterface $quickOrder);

    /**
     * @param int $id
     * @return QuickOrderRepositoryInterface
     */

    public function deleteById(int $id);
}
