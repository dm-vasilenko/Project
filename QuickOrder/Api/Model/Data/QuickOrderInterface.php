<?php

namespace Thesis\QuickOrder\Api\Model\Data;

/**
 * Interface QuickOrderInterface
 *
 * @package Thesis\QuickOrder\Api\Model\Data
 */
interface QuickOrderInterface
{
    const CACHE_TAG             = 'thesis_quickorder';
    const REGISTRY_KEY          = 'thesis_quickorder_order';
    const ID_FIELD              = 'order_id';
    const NAME_COL_NAME         = 'name';
    const SKU_COL_NAME          = 'sku';
    const PHONE_COL_NAME        = 'phone';
    const EMAIL_COL_NAME        = 'email';
    const CREATED_AT_COL_NAME   = 'created_at';
    const UPDATED_AT_COL_NAME   = 'updated_at';
    const STATUS_COL_NAME       = 'status';

    /**
     * @return int|null
     */
    public function getId();

    /**
     * @param string $name
     * @return QuickOrderInterface
     */
    public function setName(string $name);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $sku
     * @return QuickOrderInterface
     */
    public function setSku(string $sku);

    /**
     * @return string
     */
    public function getSku();

    /**
     * @param string $phone
     * @return QuickOrderInterface
     */
    public function setPhone(string $phone);

    /**
     * @return string
     */
    public function getPhone();

    /**
     * @param string $email
     * @return QuickOrderInterface
     */
    public function setEmail(string $email);

    /**
     * @return string
     */
    public function getEmail();

    /**
     * @param StatusInterface $status
     * @return QuickOrderInterface
     */
    public function setStatus(StatusInterface $status);

    /**
     * @return StatusInterface
     */
    public function getStatus();

    /**
     * @return \DateTimeInterface
     */
    public function getCreatedAt();

    /**
     * @return \DateTimeInterface
     */
    public function getUpdatedAt();
}
