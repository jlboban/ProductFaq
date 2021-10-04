<?php

declare(strict_types=1);

namespace Inchoo\ProductFaq\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;

class Config
{
    public const PRODUCT_FAQ_ACTIVE = "catalog/product_faq/product_faq_active";

    /**
     * @var ScopeConfigInterface
     */
    protected $config;

    /**
     * @param ScopeConfigInterface $config
     */
    public function __construct(ScopeConfigInterface $config)
    {
        $this->config = $config;
    }

    /**
     * @return mixed
     */
    public function getProductFaqActive()
    {
        return $this->config->getValue(self::PRODUCT_FAQ_ACTIVE);
    }
}
