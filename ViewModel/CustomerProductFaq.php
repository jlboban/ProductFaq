<?php

declare(strict_types=1);

namespace Inchoo\ProductFaq\ViewModel;

use Inchoo\ProductFaq\Api\Data\ProductFaqInterface;
use Inchoo\ProductFaq\Model\ResourceModel\ProductFaq\Collection;
use Inchoo\ProductFaq\Model\ResourceModel\ProductFaq\CollectionFactory;
use Magento\Catalog\Model\ProductRepository;
use Magento\Customer\Model\Session;
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
     * @var ProductRepository
     */
    protected $productRepository;

    /**
     * ProductFaq constructor.
     * @param RequestInterface $request
     * @param Session $session
     * @param CollectionFactory $productFaqCollectionFactory
     * @param StoreManager $storeManager
     * @param ProductRepository $productRepository
     */
    public function __construct(
        RequestInterface $request,
        Session $session,
        CollectionFactory $productFaqCollectionFactory,
        StoreManager $storeManager,
        ProductRepository $productRepository
    ) {
        $this->request = $request;
        $this->session = $session;
        $this->productFaqCollectionFactory = $productFaqCollectionFactory;
        $this->storeManager = $storeManager;
        $this->productRepository = $productRepository;
    }

    /**
     * @return Collection
     * @throws NoSuchEntityException
     */
    public function getCustomerQuestions(): Collection
    {
        $storeId = $this->storeManager->getStore()->getId();

        $collection = $this->productFaqCollectionFactory->create();
        $collection->addFieldToFilter(ProductFaqInterface::STORE_ID, $storeId);
        $collection->addFieldToFilter(ProductFaqInterface::CUSTOMER_ID, $this->session->getCustomerId());

        return $collection;
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
