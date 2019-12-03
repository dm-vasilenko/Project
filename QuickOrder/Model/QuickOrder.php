<?php

namespace Thesis\QuickOrder\Model;

use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Thesis\QuickOrder\Api\Model\Data\QuickOrderInterface;
use Thesis\QuickOrder\Api\Model\Data\StatusInterface;
use Thesis\QuickOrder\Api\Model\Schema\QuickOrderSchemaInterface;
use Thesis\QuickOrder\Model\ResourceModel\QuickOrder as ResourceModel;

/**
 * Class QuickOrder
 * @package Thesis\QuickOrder\Model
 */
class QuickOrder extends AbstractModel implements QuickOrderInterface
{
    private $statusRepository;
    /**
     * @var StatusInterface
     */
    private $status;
    /**
     * @var TimezoneInterface
     */
    private $timezone;
    /**
     * QuickOrder constructor.
     * @param Context $context
     * @param Registry $registry
     * @param TimezoneInterface $timezone
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        TimezoneInterface $timezone,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->timezone = $timezone;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * @return void
     */
    public function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * @param string $name
     * @return QuickOrderInterface
     */
    public function setName(string $name): QuickOrderInterface
    {
        $this->setData(QuickOrderSchemaInterface::NAME_COL_NAME, $name);

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->getData(QuickOrderSchemaInterface::NAME_COL_NAME);
    }

    /**
     * @param string $sku
     * @return QuickOrderInterface
     */
    public function setSku(string $sku): QuickOrderInterface
    {
        $this->setData(QuickOrderSchemaInterface::SKU_COL_NAME, $sku);

        return $this;
    }

    /**
     * @return string
     */
    public function getSku(): string
    {
        return $this->getData(QuickOrderSchemaInterface::SKU_COL_NAME);
    }

    /**
     * @param string $phone
     * @return QuickOrderInterface
     */
    public function setPhone(string $phone): QuickOrderInterface
    {
        $this->setData(QuickOrderSchemaInterface::PHONE_COL_NAME, $phone);

        return $this;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->getData(QuickOrderSchemaInterface::PHONE_COL_NAME);
    }

    /**
     * @param string $email
     * @return QuickOrderInterface
     */
    public function setEmail(string $email): QuickOrderInterface
    {
        $this->setData(QuickOrderSchemaInterface::EMAIL_COL_NAME, $email);

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->getData(QuickOrderSchemaInterface::EMAIL_COL_NAME);
    }

    /**
     * @param StatusInterface $status
     * @return QuickOrderInterface
     * @throws LocalizedException
     */
    public function setStatus(StatusInterface $status): QuickOrderInterface
    {
        if (null === $status->getId()) {
            throw new LocalizedException(__('Status not created'));
        }

        $this->setData(QuickOrderSchemaInterface::STATUS_COL_NAME, $status->getId());

        return $this;
    }

    /**
     * @return StatusInterface
     */
    public function getStatus(): StatusInterface
    {
        $statusId =  $this->getData(QuickOrderSchemaInterface::STATUS_COL_NAME);

        if (null === $this->status) {
            // @TODO load status by ID
        }

        return $this->status;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getCreatedAt(): \DateTimeInterface
    {
        $timestamp = $this->getData(QuickOrderSchemaInterface::CREATED_AT_COL_NAME);

        return $this->timezone->date($timestamp);
    }

    /**
     * @return \DateTimeInterface
     */
    public function getUpdatedAt(): \DateTimeInterface
    {
        $timestamp = $this->getData(QuickOrderSchemaInterface::UPDATED_AT_COL_NAME);

        return $this->timezone->date($timestamp);
    }
}
