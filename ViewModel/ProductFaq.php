<?php

declare(strict_types=1);

namespace Inchoo\ProductFaq\ViewModel;

use Inchoo\ProductFaq\Api\Data\ProductFaqInterface;
use Inchoo\ProductFaq\Api\ProductFaqRepositoryInterface;
use Inchoo\ProductFaq\Model\ResourceModel\ProductFaq\CollectionFactory;
use Magento\Customer\Model\Session;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\Http\Context;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Store\Model\StoreManager;

class ProductFaq implements ArgumentInterface
{
    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var Session
     */
    protected $session;

    /**
     * @var CollectionFactory
     */
    protected $productFaqCollectionFactory;

    /**
     * @var StoreManager
     */
    protected $storeManager;

    /**
     * @var ProductFaqRepositoryInterface
     */
    protected $productFaqRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @var Context
     */
    protected $httpContext;

    /**
     * ProductFaq constructor.
     * @param RequestInterface $request
     * @param Session $session
     * @param CollectionFactory $productFaqCollectionFactory
     * @param StoreManager $storeManager
     * @param ProductFaqRepositoryInterface $productFaqRepository
     */
    public function __construct(
        RequestInterface              $request,
        Session                       $session,
        CollectionFactory             $productFaqCollectionFactory,
        StoreManager                  $storeManager,
        ProductFaqRepositoryInterface $productFaqRepository,
        SearchCriteriaBuilder         $searchCriteriaBuilder,
        Context                       $httpContext
    ) {
        $this->request = $request;
        $this->session = $session;
        $this->productFaqCollectionFactory = $productFaqCollectionFactory;
        $this->storeManager = $storeManager;
        $this->productFaqRepository = $productFaqRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->httpContext = $httpContext;
    }

    /**
     * @return bool
     */
    public function isLoggedIn(): bool
    {
        return (bool)$this->httpContext->getValue(\Magento\Customer\Model\Context::CONTEXT_AUTH);
    }

    /**
     * @return string|null
     */
    public function getProductId(): ?string
    {
        return $this->request->getParam('id');
    }

    /**
     * @return DataObject[]
     * @throws NoSuchEntityException
     */
    public function getProductQuestions(): array
    {
        $storeId = $this->storeManager->getStore()->getId();

        if (!$productId = $this->getProductId()) {
            return [];
        }

        $collection = $this->productFaqCollectionFactory->create();
        $collection->addFieldToFilter(ProductFaqInterface::IS_LISTED, 1);
        $collection->addFieldToFilter(ProductFaqInterface::PRODUCT_ID, $productId);
        $collection->addFieldToFilter(ProductFaqInterface::STORE_ID, $storeId);

        return $collection->getItems();
    }

    /**
     * @param int $productId
     * @return bool
     */
    public function hasCustomerSubmittedQuestionForProduct(int $productId): bool
    {
        $this->searchCriteriaBuilder
            ->addFilter(ProductFaqInterface::CUSTOMER_ID, $this->session->getCustomerId(), 'eq')
            ->addFilter(ProductFaqInterface::PRODUCT_ID, $productId, 'eq');

        $searchCriteria = $this->searchCriteriaBuilder->create();
        return $this->productFaqRepository->getList($searchCriteria)->getTotalCount() > 0;
    }
}
