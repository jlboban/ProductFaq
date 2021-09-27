<?php

declare(strict_types=1);

namespace Inchoo\ProductFaq\ViewModel;

use Inchoo\ProductFaq\Api\Data\ProductFaqInterface;
use Inchoo\ProductFaq\Model\ResourceModel\ProductFaq\Collection;
use Inchoo\ProductFaq\Model\ResourceModel\ProductFaq\CollectionFactory;
use Magento\Customer\Model\Session;
use Magento\Framework\App\RequestInterface;
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
     * ProductFaq constructor.
     * @param RequestInterface $request
     * @param Session $session
     * @param CollectionFactory $productFaqCollectionFactory
     * @param StoreManager $storeManager
     */
    public function __construct(
        RequestInterface $request,
        Session $session,
        CollectionFactory $productFaqCollectionFactory,
        StoreManager $storeManager
    ) {
        $this->request = $request;
        $this->session = $session;
        $this->productFaqCollectionFactory = $productFaqCollectionFactory;
        $this->storeManager = $storeManager;
    }

    /**
     * @return bool
     */
    public function isLoggedIn(): bool
    {
        return $this->session->isLoggedIn();
    }

    /**
     * @return string|null
     */
    public function getProductId(): ?string
    {
        return $this->request->getParam('id');
    }

    public function getProductQuestions(): Collection
    {
        $storeId = $this->storeManager->getStore()->getId();
        $productId = $this->request->getParam('id');

        $collection = $this->productFaqCollectionFactory->create();
        $collection->addFieldToFilter(ProductFaqInterface::IS_LISTED, 1);
        $collection->addFieldToFilter(ProductFaqInterface::PRODUCT_ID, $productId);
        $collection->addFieldToFilter(ProductFaqInterface::STORE_ID, $storeId);

        return $collection;
    }
}
