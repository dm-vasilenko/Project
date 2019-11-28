<?php

namespace Thesis\QuickOrder\Api\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Data\SearchResultInterface;
use Thesis\QuickOrder\Api\Model\Data\StatusInterface;

interface StatusRepositoryInterface
{
    /**
     * @param int $id
     * @return StatusInterface
     */
    public function getById(int $id);
    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
    /**
     * @param StatusInterface $status
     * @return StatusRepositoryInterface
     */
    public function save(StatusInterface $status);
    /**
     * @param StatusInterface $status
     * @return StatusRepositoryInterface
     */
    public function delete(StatusInterface $status);
    /**
     * @param int $id
     * @return StatusRepositoryInterface
     */
    public function deleteById(int $id);

}
