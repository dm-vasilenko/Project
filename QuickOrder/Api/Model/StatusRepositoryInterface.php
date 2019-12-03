<?php

namespace Thesis\QuickOrder\Api\Model;

use Thesis\QuickOrder\Api\Model\Data\StatusInterface;

/**
 * Interface StatusRepositoryInterface
 *
 * @package Thesis\QuickOrder\Api\Model
 */
interface StatusRepositoryInterface
{
    /**
     * @param  int $id
     * @return StatusInterface
     */
    public function getById(int $id);

    /**
     * @param  StatusInterface $status
     * @return StatusRepositoryInterface
     */
    public function save(StatusInterface $status);

    /**
     * @param  StatusInterface $status
     * @return StatusRepositoryInterface
     */
    public function delete(StatusInterface $status);

    /**
     * @param  int $id
     * @return StatusRepositoryInterface
     */
    public function deleteById(int $id);
}
