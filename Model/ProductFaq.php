<?php

declare(strict_types=1);

namespace Inchoo\ProductFaq\Model;

use Inchoo\ProductFaq\Api\Data\ProductFaqInterface;
use Inchoo\ProductFaq\Model\ResourceModel\ProductFaq as ResourceModel;
use Magento\Framework\Model\AbstractModel;

class ProductFaq extends AbstractModel implements ProductFaqInterface
{
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * @return mixed|null
     */
    public function getEntityId()
    {
        return $this->_getData(ProductFaqInterface::ENTITY_ID);
    }

    /**
     * @param mixed|null $entityId
     * @return ProductFaq
     */
    public function setEntityId($entityId)
    {
        return $this->setData(ProductFaqInterface::ENTITY_ID, $entityId);
    }

    /**
     * @return mixed|null
     */
    public function getProductId()
    {
        return $this->_getData(ProductFaqInterface::ENTITY_ID);
    }

    /**
     * @param mixed|null $productId
     * @return ProductFaq
     */
    public function setProductId($productId)
    {
        return $this->setData(ProductFaqInterface::PRODUCT_ID, $productId);
    }

    /**
     * @return mixed|null
     */
    public function getStoreId()
    {
        return $this->_getData(ProductFaqInterface::ENTITY_ID);
    }

    /**
     * @param mixed|null $storeId
     * @return ProductFaq
     */
    public function setStoreId($storeId)
    {
        return $this->setData(ProductFaqInterface::STORE_ID, $storeId);
    }

    /**
     * @return mixed|null
     */
    public function getCustomerId()
    {
        return $this->_getData(ProductFaqInterface::CUSTOMER_ID);
    }

    /**
     * @param mixed|null $customerId
     * @return ProductFaq
     */
    public function setCustomerId($customerId)
    {
        return $this->setData(ProductFaqInterface::CUSTOMER_ID, $customerId);
    }


    /**
     * @return mixed|null
     */
    public function getQuestion()
    {
        return $this->_getData(ProductFaqInterface::QUESTION);
    }

    /**
     * @param mixed|null $question
     * @return ProductFaq
     */
    public function setQuestion($question)
    {
        return $this->setData(ProductFaqInterface::QUESTION, $question);
    }

    /**
     * @return mixed|null
     */
    public function getAnswer()
    {
        return $this->_getData(ProductFaqInterface::ANSWER);
    }

    /**
     * @param mixed|null $answer
     * @return ProductFaq
     */
    public function setAnswer($answer)
    {
        return $this->setData(ProductFaqInterface::ENTITY_ID, $answer);
    }

    /**
     * @return mixed|null
     */
    public function getIsListed()
    {
        return $this->_getData(ProductFaqInterface::IS_LISTED);
    }

    /**
     * @param mixed|null $isListed
     * @return ProductFaq
     */
    public function setIsListed($isListed)
    {
        return $this->setData(ProductFaqInterface::IS_LISTED, $isListed);
    }
}
