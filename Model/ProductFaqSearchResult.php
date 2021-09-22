<?php

declare(strict_types=1);

namespace Inchoo\ProductFaq\Model;

use Inchoo\ProductFaq\Api\Data\ProductFaqSearchResultInterface;
use Magento\Framework\Api\SearchResults;

class ProductFaqSearchResult extends SearchResults implements ProductFaqSearchResultInterface
{
}
