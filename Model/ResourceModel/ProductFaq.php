<?php

declare(strict_types=1);

namespace Inchoo\ProductFaq\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class ProductFaq extends AbstractDb
{
    /**
     * Inchoo\ProductFaq\Model\ResourceModel\ProductFaq constructor.
     * @return void
     */
    protected function _construct()
    {
        $this->_init('inchoo_product_faq', 'entity_id');
    }
}
