<?php


namespace Thesis\QuickOrder\UI\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class OrderActions
 * @package Thesis\QuickOrder\UI\Component\Listing\Column
 */
class OrderActions extends Column
{
    const URL_PATH_DELETE = 'quickorder/index/delete';
    /** @var UrlInterface */
    protected $urlBuilder;
    /** @var string  */
    /**
     * @param ContextInterface      $context
     * @param UiComponentFactory    $uiComponentFactory
     * @param UrlInterface          $urlBuilder
     * @param array                 $components
     * @param array                 $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }
    /** {@inheritdoc} */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $name = $this->getData('name');
                if (isset($item['order_id'])) {
                    $item[$name]['delete'] = [
                        'href' => $this->urlBuilder->getUrl(self::URL_PATH_DELETE, ['id' => $item['order_id']]),
                        'label' => __('Delete'),
                        'confirm' => [
                            'title' => __('Delete "${ $.$data.order_id }"'),
                            'message' => __('Are you sure you wan\'t to delete a "${ $.$data.order_id }" record?')
                        ]
                    ];
                }
            }
        }

        return $dataSource;
    }
}
