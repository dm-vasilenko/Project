<?php
namespace Thesis\QuickOrder\Controller\Adminhtml\Index;

use Magento\Backend\App\Action\Context;
use Magento\Cms\Controller\Adminhtml\Page\PostDataProcessor;
use Magento\Framework\Controller\Result\JsonFactory;

use Thesis\QuickOrder\Api\Model\Data\StatusInterface;
use Thesis\QuickOrder\Api\Model\Data\StatusInterfaceFactory;
use Thesis\QuickOrder\Api\Model\StatusRepositoryInterface as StatusRepository;
use Thesis\QuickOrder\Model\ResourceModel\StatusFactory;

/**
 * Cms page grid inline edit controller
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class InlineEditStatus extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Thesis_QuickOrder::status';
    /**
     * @var \Magento\Cms\Controller\Adminhtml\Page\PostDataProcessor
     */
    protected $dataProcessor;
    /**
     * @var \Thesis\QuickOrder\Api\Model\StatusRepositoryInterface
     */
    protected $statusRepository;
    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $jsonFactory;
    /**
     * @var StatusFactory;
     */
    protected $statusResourceFactory;
    /**
     * @var StatusInterfaceFactory
     */
    protected $statusModelFactory;

    /**
     * @param Context $context
     * @param StatusFactory $statusResourceFactory
     * @param StatusInterfaceFactory $statusModelFactory
     * @param PostDataProcessor $dataProcessor
     * @param statusRepository $statusRepository
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        Context $context,
        StatusFactory $statusResourceFactory,
        StatusInterfaceFactory $statusModelFactory,
        PostDataProcessor $dataProcessor,
        StatusRepository $statusRepository,
        JsonFactory $jsonFactory
    ) {
        parent::__construct($context);
        $this->statusResourceFactory = $statusResourceFactory;
        $this->statusModelFactory = $statusModelFactory;
        $this->dataProcessor = $dataProcessor;
        $this->statusRepository = $statusRepository;
        $this->jsonFactory = $jsonFactory;
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];
        $statusItems = $this->getRequest()->getParam('items', []);
        $array = array_values($statusItems);
        $defaultAfter = $array[0]["is_default"];
        if (!($this->getRequest()->getParam('isAjax') && count($statusItems))) {
            return $resultJson->setData([
                'messages' => [__('Please correct the data sent.')],
                'error' => true,
            ]);
        }

        foreach (array_keys($statusItems) as $statusId) {
            /** @var \Thesis\QuickOrder\Model\Status $status
             *@var \Thesis\QuickOrder\Model\Status $modelStatus
             */
            $status = $this->statusRepository->getById($statusId);
            $defaultBefore = $status->getData('is_default');
            $modelStatus = $this->statusModelFactory->create();
            try {
                if (($defaultBefore == "0") && ($defaultAfter == "1")) {
                    $this->statusResourceFactory->create()->load($modelStatus, "1", "is_default");
                    $modelStatus->setIsDefault(0);
                    $this->statusRepository->save($modelStatus);
                } elseif (($defaultBefore == "1") && ($defaultAfter == "0")) {
                    throw new \Magento\Framework\Exception\LocalizedException(
                        __('at least one status should be by default')
                    );
                }
                $statusData = $this->filterPost($statusItems[$statusId]);
                $this->validatePost($statusData, $status, $error, $messages);
                $extendedStatusData = $status->getData();
                $this->setCmsPageData($status, $extendedStatusData, $statusData);
                $this->statusRepository->save($status);
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $messages[] = $this->getErrorWithPageId($status, $e->getMessage());
                $error = true;
            } catch (\RuntimeException $e) {
                $messages[] = $this->getErrorWithPageId($status, $e->getMessage());
                $error = true;
            } catch (\Exception $e) {
                $messages[] = $this->getErrorWithPageId(
                    $status,
                    __('Something went wrong while saving the status.')
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
        $statusData = $this->dataProcessor->filter($postData);
        $statusData['custom_theme'] = isset($statusData['custom_theme']) ? $statusData['custom_theme'] : null;
        $statusData['custom_root_template'] = isset($statusData['custom_root_template'])
            ? $statusData['custom_root_template']
            : null;
        return $statusData;
    }

    /**
     * Validate post data
     *
     * @param array $statusData
     * @param \Thesis\QuickOrder\Model\Status $status
     * @param bool $error
     * @param array $messages
     * @return void
     */
    protected function validatePost(
        array $statusData,
        \Thesis\QuickOrder\Model\Status $status,
        &$error,
        array &$messages
    ) {
        if (!($this->dataProcessor->validate($statusData) && $this->dataProcessor->validateRequireEntry($statusData))) {
            $error = true;
            foreach ($this->messageManager->getMessages(true)->getItems() as $error) {
                $messages[] = $this->getErrorWithPageId($status, $error->getText());
            }
        }
    }
    /**
     * Add page title to error message
     *
     * @param StatusInterface $status
     * @param string $errorText
     * @return string
     */
    protected function getErrorWithPageId(StatusInterface $status, $errorText)
    {
        return '[Status ID: ' . $status->getId() . '] ' . $errorText;
    }
    /**
     * @param \Thesis\QuickOrder\Model\Status $status
     * @param array $extendedStatusData
     * @param array $statusData
     * @return $this
     */
    public function setCmsPageData(
        \Thesis\QuickOrder\Model\Status $status,
        array $extendedStatusData,
        array $statusData
    ) {
        $status->setData(array_merge($status->getData(), $extendedStatusData, $statusData));
        return $this;
    }
}
