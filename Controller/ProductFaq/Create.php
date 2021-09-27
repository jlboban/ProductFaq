<?php

declare(strict_types=1);

namespace Inchoo\ProductFaq\Controller\ProductFaq;

use Inchoo\ProductFaq\Api\ProductFaqRepositoryInterface;
use Inchoo\ProductFaq\Model\ProductFaqFactory;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Message\ManagerInterface;
use Magento\Store\Model\StoreManager;
use Psr\Log\LoggerInterface;

class Create implements HttpPostActionInterface
{
    private const PRODUCT_FAQ_TAB_URL_SUFFIX = '#faq';

    /**
     * @var ResultFactory
     */
    protected $resultFactory;

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
    protected $session;

    /**
     * Create constructor.
     * @param ResultFactory $resultFactory
     * @param ManagerInterface $messageManager
     * @param RequestInterface $request
     * @param ProductFaqFactory $productFaqFactory
     * @param ProductFaqRepositoryInterface $productFaqRepository
     * @param StoreManager $storeManager
     * @param ProductRepositoryInterface $productRepository
     * @param LoggerInterface $logger
     * @param Session $session
     */
    public function __construct(
        ResultFactory                 $resultFactory,
        ManagerInterface              $messageManager,
        RequestInterface              $request,
        ProductFaqFactory             $productFaqFactory,
        ProductFaqRepositoryInterface $productFaqRepository,
        StoreManager                  $storeManager,
        ProductRepositoryInterface    $productRepository,
        LoggerInterface               $logger,
        Session                       $session
    ) {
        $this->resultFactory = $resultFactory;
        $this->messageManager = $messageManager;
        $this->request = $request;
        $this->productFaqFactory = $productFaqFactory;
        $this->productFaqRepository = $productFaqRepository;
        $this->storeManager = $storeManager;
        $this->productRepository = $productRepository;
        $this->logger = $logger;
        $this->session = $session;
    }

    /**
     * @return Redirect|ResultInterface
     * @throws NoSuchEntityException
     */
    public function execute()
    {
        $this->session->authenticate();

        $data = $this->request->getParams();
        $storeId = $this->storeManager->getStore()->getId();
        $productId = $data['product_id'];

        $product = $this->productRepository->getById($productId, false, $storeId);

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setPath($product->getProductUrl() . self::PRODUCT_FAQ_TAB_URL_SUFFIX);

        $productFaq = $this->productFaqFactory->create();
        $productFaq->setProductId($productId);
        $productFaq->setStoreId($storeId);
        $productFaq->setCustomerId($this->session->getCustomerId());
        $productFaq->setQuestion($data['question']);

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
