<?php
namespace Thesis\QuickOrder\Controller\Adminhtml\Index;

use Magento\Backend\App\Action\Context;
use Magento\Cms\Controller\Adminhtml\Page\PostDataProcessor;
use Magento\Framework\Controller\Result\JsonFactory;

use Thesis\QuickOrder\Api\Model\Data\QuickOrderInterface;

use Thesis\QuickOrder\Api\Model\QuickOrderRepositoryInterface as OrderRepository;

/**
 * Class InlineEdit
 * @package Thesis\QuickOrder\Controller\Adminhtml\Index
 */
class InlineEdit extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Thesis_QuickOrder::order';
    /**
     * @var \Magento\Cms\Controller\Adminhtml\Page\PostDataProcessor
     */
    protected $dataProcessor;
    /**
     * @var \Thesis\QuickOrder\Api\Model\QuickOrderRepositoryInterface
     */
    protected $orderRepository;
    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $jsonFactory;
    /**
     * @param Context $context
     * @param PostDataProcessor $dataProcessor
     * @param orderRepository $orderRepository
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        Context $context,
        PostDataProcessor $dataProcessor,
        OrderRepository $orderRepository,
        JsonFactory $jsonFactory
    ) {
        parent::__construct($context);
        $this->dataProcessor = $dataProcessor;
        $this->orderRepository = $orderRepository;
        $this->jsonFactory = $jsonFactory;
    }
    /**
     * @return \Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];
        $orderItems = $this->getRequest()->getParam('items', []);
        if (!($this->getRequest()->getParam('isAjax') && count($orderItems))) {
            return $resultJson->setData([
                'messages' => [__('Please correct the data sent.')],
                'error' => true,
            ]);
        }

        foreach (array_keys($orderItems) as $orderId) {
            /** @var \Thesis\QuickOrder\Model\QuickOrder $order */
            $order = $this->orderRepository->getById($orderId);
            try {
                $orderData = $this->filterPost($orderItems[$orderId]);
                $this->validatePost($orderData, $order, $error, $messages);
                $extendedOrderData = $order->getData();
                $this->setCmsPageData($order, $extendedOrderData, $orderData);

                $this->orderRepository->save($order);
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $messages[] = $this->getErrorWithPageId($order, $e->getMessage());
                $error = true;
            } catch (\RuntimeException $e) {
                $messages[] = $this->getErrorWithPageId($order, $e->getMessage());
                $error = true;
            } catch (\Exception $e) {
                $messages[] = $this->getErrorWithPageId(
                    $order,
                    __('Something went wrong while saving the order.')
                );
                $error = true;
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }
    /**
     * @param array $postData
     * @return array
     */
    protected function filterPost($postData = [])
    {
        $orderData = $this->dataProcessor->filter($postData);
        $orderData['custom_theme'] = isset($orderData['custom_theme']) ? $orderData['custom_theme'] : null;
        $orderData['custom_root_template'] = isset($orderData['custom_root_template'])
            ? $orderData['custom_root_template']
            : null;
        return $orderData;
    }

    /**
     * Validate post data
     *
     * @param array $orderData
     * \Thesis\QuickOrder\Model\QuickOrder $order
     * @param \Thesis\QuickOrder\Model\QuickOrder $order
     * @param bool $error
     * @param array $messages
     * @return void
     */
    protected function validatePost(
        array $orderData,
        \Thesis\QuickOrder\Model\QuickOrder $order,
        &$error,
        array &$messages
    ) {
        if (!($this->dataProcessor->validate($orderData) && $this->dataProcessor->validateRequireEntry($orderData))) {
            $error = true;
            foreach ($this->messageManager->getMessages(true)->getItems() as $error) {
                $messages[] = $this->getErrorWithPageId($order, $error->getText());
            }
        }
    }
    /**
     * Add page title to error message
     *
     * @param QuickOrderInterface $order
     * @param string $errorText
     * @return string
     */
    protected function getErrorWithPageId(QuickOrderInterface $order, $errorText)
    {
        return '[Order ID: ' . $order->getId() . '] ' . $errorText;
    }
    /**
     * Set cms page data
     *
     * @param \Thesis\QuickOrder\Model\QuickOrder $order
     * @param array $extendedOrderData
     * @param array $orderData
     * @return $this
     */
    public function setCmsPageData(
        \Thesis\QuickOrder\Model\QuickOrder $order,
        array $extendedOrderData,
        array $orderData
    ) {
        $order->setData(array_merge($order->getData(), $extendedOrderData, $orderData));
        return $this;
    }
}
