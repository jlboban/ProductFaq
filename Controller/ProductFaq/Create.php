<?php

declare(strict_types=1);

namespace Inchoo\ProductFaq\Controller\ProductFaq;

use Inchoo\ProductFaq\Api\ProductFaqRepositoryInterface;
use Inchoo\ProductFaq\Model\Config;
use Inchoo\ProductFaq\Model\ProductFaqFactory;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Customer\Model\Session;
use Magento\Customer\Model\Url as CustomerUrl;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\ForwardFactory;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Event\ManagerInterface as EventManager;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Message\ManagerInterface;
use Magento\Store\Model\StoreManager;
use Psr\Log\LoggerInterface;

class Create implements HttpPostActionInterface
{
    private const PRODUCT_FAQ_TAB_URL_SUFFIX = '#faq';
    private const QUESTION_MIN_LENGTH = 16;

    /**
     * @var ResultFactory
     */
    protected $resultFactory;

    /**
     * @var ForwardFactory
     */
    protected $forwardFactory;

    /**
     * @var ManagerInterface
     */
    protected $messageManager;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var ProductFaqFactory
     */
    protected $productFaqFactory;

    /**
     * @var ProductFaqRepositoryInterface
     */
    protected $productFaqRepository;

    /**
     * @var StoreManager
     */
    protected $storeManager;

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var Session
     */
    protected $customerSession;

    /**
     * @var EventManager
     */
    protected $eventManager;

    /**
     * @var Url
     */
    protected $customerUrl;

    /**
     * @var Config
     */
    protected $config;

    /**
     * Create constructor.
     * @param ResultFactory $resultFactory
     * @param ForwardFactory $forwardFactory
     * @param ManagerInterface $messageManager
     * @param RequestInterface $request
     * @param ProductFaqFactory $productFaqFactory
     * @param ProductFaqRepositoryInterface $productFaqRepository
     * @param StoreManager $storeManager
     * @param ProductRepositoryInterface $productRepository
     * @param LoggerInterface $logger
     * @param Session $customerSession
     * @param EventManager $eventManager
     * @param CustomerUrl $customerUrl
     * @param Config $config
     */
    public function __construct(
        ResultFactory $resultFactory,
        ForwardFactory $forwardFactory,
        ManagerInterface $messageManager,
        RequestInterface $request,
        ProductFaqFactory $productFaqFactory,
        ProductFaqRepositoryInterface $productFaqRepository,
        StoreManager $storeManager,
        ProductRepositoryInterface $productRepository,
        LoggerInterface $logger,
        Session $customerSession,
        EventManager $eventManager,
        CustomerUrl $customerUrl,
        Config $config
    ) {
        $this->resultFactory = $resultFactory;
        $this->forwardFactory = $forwardFactory;
        $this->messageManager = $messageManager;
        $this->request = $request;
        $this->productFaqFactory = $productFaqFactory;
        $this->productFaqRepository = $productFaqRepository;
        $this->storeManager = $storeManager;
        $this->productRepository = $productRepository;
        $this->logger = $logger;
        $this->customerSession = $customerSession;
        $this->eventManager = $eventManager;
        $this->customerUrl = $customerUrl;
        $this->config = $config;
    }

    /**
     * @return Redirect|ResultInterface
     * @throws NoSuchEntityException
     */
    public function execute()
    {
        if (!$this->config->getProductFaqActive()) {
            return $this->forwardFactory->create()->forward('noroute');
        }

        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        if (!$this->customerSession->authenticate()) {
            $resultRedirect->setPath($this->customerUrl->getLoginUrl());
            return $resultRedirect;
        }

        $data = $this->request->getParams();

        try {
            $product = $this->productRepository->getById($data['product_id']);
        } catch (NoSuchEntityException $e) {
            $this->messageManager->addErrorMessage(__('Product was not found.'));
            return $this->forwardFactory->create()->forward('noroute');
        }

        $resultRedirect->setPath($product->getProductUrl() . self::PRODUCT_FAQ_TAB_URL_SUFFIX);

        $question = trim($this->request->getParam('question', ''));
        if (mb_strlen($question) < self::QUESTION_MIN_LENGTH) {
            $this->messageManager->addErrorMessage(
                __("Please enter at least %1 characters", self::QUESTION_MIN_LENGTH)
            );

            return $resultRedirect;
        }

        $productFaq = $this->productFaqFactory->create();
        $productFaq->setQuestion($data['question']);
        $productFaq->setProductId($data['product_id']);
        $productFaq->setStoreId($this->storeManager->getStore()->getId());
        $productFaq->setCustomerId($this->customerSession->getCustomerId());

        $this->eventManager->dispatch('create_product_faq', ['productFaq' => $productFaq]);

        try {
            $this->productFaqRepository->save($productFaq);
            $this->messageManager->addSuccessMessage(__('Successfully submitted question!'));
        } catch (CouldNotSaveException $e) {
            $this->messageManager->addErrorMessage(__('That question has already been submitted for this product.'));
        } catch (\Exception $e) {
            $this->logger->error('Tried to create a new product FAQ', [
                'productName' => $product->getName(),
                'question' => $data['question'],
                'exception' => $e->getMessage()
            ]);

            $this->messageManager->addErrorMessage(__('Something went wrong, please try again or contact support.'));
        }

        return $resultRedirect;
    }
}
