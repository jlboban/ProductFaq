<?php

declare(strict_types=1);

namespace Inchoo\ProductFaq\Model\ResourceModel\ProductFaq;

use Inchoo\ProductFaq\Model\ProductFaq as ProductFaqModel;
use Inchoo\ProductFaq\Model\ResourceModel\ProductFaq as ProductFaqResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ProductFaqModel::class, ProductFaqResource::class);
    }
}
