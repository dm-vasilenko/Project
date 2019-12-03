<?php

namespace Thesis\QuickOrder\Block;

use Magento\Catalog\Model\Product;
use Magento\Framework\View\Element\Template;

/**
 * Class QuickOrder
 * @package Thesis\QuickOrder\Block
 */
class QuickOrder extends Template
{
    /**
     * @var Product
     */
    protected $product;

    /**
     * @param Template\Context $context
     * @param Product          $product
     * @param array            $data
     */
    public function __construct(
        Template\Context $context,
        Product $product,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->product = $product;
    }

    /**
     * @return string
     */
    public function getProductSku()
    {
        return $productSku = !empty($this->product) ? $this->product->getSku() : "";
    }

    /**
     * @param  $product
     * @return $this
     */
    public function setProduct($product)
    {
        $this->product = $product;

        return $this;
    }
}
