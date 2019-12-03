<?php

namespace Thesis\QuickOrder\Api\Model\Data;

/**
 * Interface QuickOrderInterface
 *
 * @package Thesis\QuickOrder\Api\Model\Data
 */
interface QuickOrderInterface
{
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
