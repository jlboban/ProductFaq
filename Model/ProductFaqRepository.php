<?php

declare(strict_types=1);

namespace Inchoo\ProductFaq\Model;

use Inchoo\ProductFaq\Api\Data\ProductFaqInterface;
use Inchoo\ProductFaq\Api\Data\ProductFaqInterfaceFactory;
use Inchoo\ProductFaq\Api\Data\ProductFaqSearchResultInterface;
use Inchoo\ProductFaq\Api\Data\ProductFaqSearchResultInterfaceFactory;
use Inchoo\ProductFaq\Api\ProductFaqRepositoryInterface;
use Inchoo\ProductFaq\Model\ResourceModel\ProductFaq as ProductFaqResource;
use Inchoo\ProductFaq\Model\ResourceModel\ProductFaq\CollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class ProductFaqRepository implements ProductFaqRepositoryInterface
{
    /**
     * @var ProductFaqResource
     */
    protected $productFaqResource;

    /**
     * @var ProductFaqInterfaceFactory
     */
    protected $productFaqFactory;

    /**
     * @var CollectionFactory
     */
    protected $productFaqCollectionFactory;

    /**
     * @var CollectionProcessorInterface
     */
    protected $collectionProcessor;

    /**
     * @var ProductFaqSearchResultInterfaceFactory
     */
    protected $productFaqSearchResultFactory;

    /**
     * ProductFaqRepository constructor.
     * @param ProductFaqResource $productFaqResource
     * @param ProductFaqInterfaceFactory $productFaqFactory
     * @param CollectionFactory $productFaqCollectionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param ProductFaqSearchResultInterfaceFactory $productFaqSearchResultFactory
     */
    public function __construct(
        ProductFaqResource $productFaqResource,
        ProductFaqInterfaceFactory $productFaqFactory,
        CollectionFactory $productFaqCollectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        ProductFaqSearchResultInterfaceFactory $productFaqSearchResultFactory
    ) {
        $this->productFaqResource = $productFaqResource;
        $this->productFaqFactory = $productFaqFactory;
        $this->productFaqCollectionFactory = $productFaqCollectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->productFaqSearchResultFactory = $productFaqSearchResultFactory;
    }

    /**
     * @param int $id
     * @return ProductFaq
     * @throws NoSuchEntityException
     */
    public function get(int $id): ProductFaq
    {
        /** @var ProductFaq $productFaq */
        $productFaq = $this->productFaqFactory->create();
        $this->productFaqResource->load($productFaq, $id);

        if (!$productFaq->getEntityId()) {
            throw new NoSuchEntityException(__('The faq with the "%1" id does not exist.', $id));
        }

        return $productFaq;
    }

    /**
     * @param ProductFaqInterface $productFaq
     * @return ProductFaqInterface
     * @throws CouldNotSaveException
     */
    public function save(ProductFaqInterface $productFaq): ProductFaqInterface
    {
        try {
            $this->productFaqResource->save($productFaq);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }

        return $productFaq;
    }

    /**
     * @param ProductFaqInterface $productFaq
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(ProductFaqInterface $productFaq): bool
    {
        try {
            $this->productFaqResource->delete($productFaq);
        } catch (\Exception $e) {
            throw new CouldNotDeleteException(__($e->getMessage()));
        }

        return true;
    }

    /**
     * @param int $id
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById(int $id): bool
    {
        return $this->delete($this->get($id));
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return ProductFaqSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): ProductFaqSearchResultInterface
    {
        $collection = $this->productFaqCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResult = $this->productFaqSearchResultFactory->create();
        $searchResult->setSearchCriteria($searchCriteria);
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());

        return $searchResult;
    }
}
