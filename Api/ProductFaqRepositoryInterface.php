<?php

declare(strict_types=1);

namespace Inchoo\ProductFaq\Api;

use Inchoo\ProductFaq\Api\Data\ProductFaqInterface;
use Inchoo\ProductFaq\Api\Data\ProductFaqSearchResultInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

interface ProductFaqRepositoryInterface
{
    /**
     * @param int $id
     * @return ProductFaqInterface
     * @throws NoSuchEntityException
     */
    public function get(int $id): ProductFaqInterface;

    /**
     * @param ProductFaqInterface $faq
     * @return ProductFaqInterface
     * @throws CouldNotSaveException
     */
    public function save(ProductFaqInterface $faq): ProductFaqInterface;

    /**
     * @param ProductFaqInterface $faq
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(ProductFaqInterface $faq): bool;

    /**
     * @param int $id
     * @return bool
     * @throws NoSuchEntityException
     * @throws CouldNotDeleteException
     */
    public function deleteById(int $id): bool;

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return ProductFaqSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): ProductFaqSearchResultInterface;
}
