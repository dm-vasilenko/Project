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
    const ADMIN_RESOURCE = 'Magento_Cms::save';
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
     * @param StatusFactory $statusRepositoryFactory
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
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];
        $postItems = $this->getRequest()->getParam('items', []);
        $array = array_values($postItems);
        $defaultAfter = $array[0]["is_default"];
        if (!($this->getRequest()->getParam('isAjax') && count($postItems))) {
            return $resultJson->setData([
                'messages' => [__('Please correct the data sent.')],
                'error' => true,
            ]);
        }

        foreach (array_keys($postItems) as $pageId) {
            /** @var \Thesis\QuickOrder\Model\Status $page
             *@var \Thesis\QuickOrder\Model\Status $modelStatus
             * @var \Magento\Framework\Exception\CouldNotSaveException $a
             */
            $page = $this->statusRepository->getById($pageId);
            $defaultBefore = $page->getData('is_default');
            $modelStatus = $this->statusModelFactory->create();
            try {
                if (($defaultBefore == "0") && ($defaultAfter == "1")) {
                    $this->statusResourceFactory->create()->load($modelStatus, "1", "is_default");
                    $modelStatus->setIsDefault(0);
                    $this->statusRepository->save($modelStatus);
                } elseif (($defaultBefore == "1") && ($defaultAfter == "0")) {
                    throw new \Magento\Framework\Exception\LocalizedException(__('at least one status should be by default'));
                }
                $pageData = $this->filterPost($postItems[$pageId]);
                $this->validatePost($pageData, $page, $error, $messages);
                $extendedPageData = $page->getData();
                $this->setCmsPageData($page, $extendedPageData, $pageData);
                $this->statusRepository->save($page);
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $messages[] = $this->getErrorWithPageId($page, $e->getMessage());
                $error = true;
            } catch (\RuntimeException $e) {
                $messages[] = $this->getErrorWithPageId($page, $e->getMessage());
                $error = true;
            } catch (\Exception $e) {
                $messages[] = $this->getErrorWithPageId(
                    $page,
                    __('Something went wrong while saving the page.')
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
     * Filtering posted data.
     *
     * @param array $postData
     * @return array
     */
    protected function filterPost($postData = [])
    {
        $pageData = $this->dataProcessor->filter($postData);
        $pageData['custom_theme'] = isset($pageData['custom_theme']) ? $pageData['custom_theme'] : null;
        $pageData['custom_root_template'] = isset($pageData['custom_root_template'])
            ? $pageData['custom_root_template']
            : null;
        return $pageData;
    }
    /**
     * Validate post data
     *
     * @param array $pageData
     * @param \Magento\Cms\Model\Page $page
     * @param bool $error
     * @param array $messages
     * @return void
     */
    protected function validatePost(array $pageData, \Thesis\QuickOrder\Model\Status $page, &$error, array &$messages)
    {
        if (!($this->dataProcessor->validate($pageData) && $this->dataProcessor->validateRequireEntry($pageData))) {
            $error = true;
            foreach ($this->messageManager->getMessages(true)->getItems() as $error) {
                $messages[] = $this->getErrorWithPageId($page, $error->getText());
            }
        }
    }
    /**
     * Add page title to error message
     *
     * @param StatusInterface $page
     * @param string $errorText
     * @return string
     */
    protected function getErrorWithPageId(StatusInterface $page, $errorText)
    {
        return '[Page ID: ' . $page->getId() . '] ' . $errorText;
    }
    /**
     * Set cms page data
     *
     * @param \Magento\Cms\Model\Page $page
     * @param array $extendedPageData
     * @param array $pageData
     * @return $this
     */
    public function setCmsPageData(\Thesis\QuickOrder\Model\Status $page, array $extendedPageData, array $pageData)
    {
        $page->setData(array_merge($page->getData(), $extendedPageData, $pageData));
        return $this;
    }
}
