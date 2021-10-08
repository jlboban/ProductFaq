<?php

declare(strict_types=1);

namespace Inchoo\ProductFaq\ViewModel;

use Inchoo\ProductFaq\Api\Data\ProductFaqInterface;
use Inchoo\ProductFaq\Model\ResourceModel\ProductFaq\CollectionFactory;
use Magento\Catalog\Model\ProductRepository;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Helper\Session\CurrentCustomer;
use Magento\Customer\Model\SessionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Store\Model\StoreManager;

class CustomerProductFaq implements ArgumentInterface
{
    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var CurrentCustomer
     */
    protected $currentCustomer;

    /**
     * @var CollectionFactory
     */
    protected $productFaqCollectionFactory;

    /**
     * @var StoreManager
     */
    protected $storeManager;

    /**
     * @var ProductRepository
     */
    protected $productRepository;

    /**
     * ProductFaq constructor.
     * @param RequestInterface $request
     * @param CurrentCustomer $currentCustomer
     * @param CollectionFactory $productFaqCollectionFactory
     * @param StoreManager $storeManager
     * @param ProductRepository $productRepository
     */
    public function __construct(
        RequestInterface  $request,
        CurrentCustomer $currentCustomer,
        CollectionFactory $productFaqCollectionFactory,
        StoreManager      $storeManager,
        ProductRepository $productRepository
    ) {
        $this->request = $request;
        $this->currentCustomer = $currentCustomer;
        $this->productFaqCollectionFactory = $productFaqCollectionFactory;
        $this->storeManager = $storeManager;
        $this->productRepository = $productRepository;
    }

    /**
     * @return CustomerInterface|null
     */
    public function getCustomer(): ?CustomerInterface
    {
        try {
            return $this->currentCustomer->getCustomer();
        } catch (NoSuchEntityException $e) {
            return null;
        }
    }

    /**
     * @return ProductFaqInterface[]
     * @throws NoSuchEntityException
     */
    public function getCustomerQuestions(): ?array
    {
        $storeId = $this->storeManager->getStore()->getId();

        $collection = $this->productFaqCollectionFactory->create();
        $collection->addFieldToFilter(ProductFaqInterface::STORE_ID, $storeId);
        $collection->addFieldToFilter(
            ProductFaqInterface::CUSTOMER_ID,
            $this->getCustomer()->getId()
        );

        return $collection->getItems();
    }

    /**
     * @param int $productId
     * @return string|null
     * @throws NoSuchEntityException
     */
    public function getProductUrl(int $productId): ?string
    {
        $product = $this->productRepository->getById($productId);
        return $product->getProductUrl();
    }

    /**
     * @param int $productId
     * @return string|null
     * @throws NoSuchEntityException
     */
    public function getProductName(int $productId): ?string
    {
        $product = $this->productRepository->getById($productId);
        return $product->getName();
    }
}
