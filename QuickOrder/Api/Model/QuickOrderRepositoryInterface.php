<?php

namespace Thesis\QuickOrder\Api\Model;

use Thesis\QuickOrder\Api\Model\Data\QuickOrderInterface;

/**
 * Interface QuickOrderRepositoryInterface
 *
 * @package Thesis\QuickOrder\Api\Model
 */
interface QuickOrderRepositoryInterface
{
    /**
     * @param  int $id
     * @return QuickOrderInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(int $id);

    /**
     * @param  QuickOrderInterface $quickorder
     * @return QuickOrderInterface
     */
    public function save(QuickOrderInterface $quickorder);

    /**
     * @param  QuickOrderInterface $quickOrder
     * @return QuickOrderRepositoryInterface
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(QuickOrderInterface $quickOrder);

    /**
     * @param  int $id
     * @return QuickOrderRepositoryInterface
     */
    public function deleteById(int $id);
}
