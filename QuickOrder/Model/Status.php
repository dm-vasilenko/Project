<?php

namespace Thesis\QuickOrder\Model;

use Magento\Framework\Model\AbstractModel;
use Thesis\QuickOrder\Api\Model\Data\StatusInterface as InterfaceStatus;
use Thesis\QuickOrder\Api\Model\Schema\StatusSchemaInterface;
use Thesis\QuickOrder\Model\ResourceModel\Status as ResourceModel;

class Status extends AbstractModel implements InterfaceStatus
{
    public function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->getData(StatusSchemaInterface::STATUS_ID_COL_NAME);

    }

    /**
     * @param string $code
     * @return InterfaceStatus
     */
    public function setStatusCode(string $code): InterfaceStatus
    {
        $this->setData(StatusSchemaInterface::STATUS_CODE_COL_NAME, $code);

        return $this;
    }

    /**
     * @return string
     */
    public function getStatusCode(): string
    {
        return $this->getData(StatusSchemaInterface::STATUS_CODE_COL_NAME);
    }

    /**
     * @param string $label
     * @return InterfaceStatus
     */
    public function setLabel(string $label): InterfaceStatus
    {
        $this->setData(StatusSchemaInterface::STATUS_LABEL_COL_NAME, $label);

        return $this;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->getData(StatusSchemaInterface::STATUS_LABEL_COL_NAME);
    }

    /**
     * @param bool $default
     * @return InterfaceStatus
     */
    public function setIsDefault(bool $default): InterfaceStatus
    {
        $this->setData(StatusSchemaInterface::IS_DEFAULT, (int) $default);

        return $this;
    }

    /**
     * @return bool
     */
    public function getIsDefault(): bool
    {
        return (bool)$this->getData(StatusSchemaInterface::IS_DEFAULT);
    }

}
