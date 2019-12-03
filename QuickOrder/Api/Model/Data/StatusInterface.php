<?php

namespace Thesis\QuickOrder\Api\Model\Data;

/**
 * Interface StatusInterface
 *
 * @package Thesis\QuickOrder\Api\Model\Data
 */
interface StatusInterface
{
    /**
     * @return mixed
     */
    public function getId();

    /**
     * @param string $code
     * @return StatusInterface
     */
    public function setStatusCode(string $code);

    /**
     * @return string
     */
    public function getStatusCode();

    /**
     * @param  string $label
     * @return StatusInterface
     */
    public function setLabel(string $label);

    /**
     * @return string
     */
    public function getLabel();

    /**
     * @param  bool $default
     * @return StatusInterface
     */
    public function setIsDefault(bool $default);

    /**
     * @return bool
     */
    public function getIsDefault();
}
