<?php

namespace Thesis\QuickOrder\Block;

use Magento\Catalog\Model\Product;
use Magento\Framework\View\Element\Template;

class QuickOrder extends Template
{
    /**
     * @var Product
     */
    protected $_product;
    /**
     * QuickOrder constructor.
     * @param Template\Context $context
     * @param Product $product
     * @param array $data
     */
    public function __construct(Template\Context $context, Product $product, array $data = [])
    {
        parent::__construct($context, $data);
        $this->_product = $product;
    }
    /**
     * @return string
     */
    public function getProductSku()
    {
        $product = $this->_product;

        $productSku = !empty($product) ? $product->getSku() : "";

        return $productSku;
    }
    /**
     * @param $product
     * @return $this
     */
    public function setProduct($product)
    {
        $this->_product = $product;

        return $this;
    }
}
