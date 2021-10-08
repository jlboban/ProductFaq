<?php

declare(strict_types=1);

namespace Inchoo\ProductFaq\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface ProductFaqSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return ProductFaqInterface[]
     */
    public function getItems();

    /**
     * @param ProductFaqInterface[] $items
     * @return ProductFaqSearchResultInterface
     */
    public function setItems(array $items);
}
