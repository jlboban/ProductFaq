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
     * @param mixed $entityId
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
     * @param int $productId
     * @return ProductFaq
     */
    public function setProductId(int $productId)
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
     * @param int $storeId
     * @return ProductFaq
     */
    public function setStoreId(int $storeId)
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
     * @param int $customerId
     * @return ProductFaq
     */
    public function setCustomerId(int $customerId)
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
     * @param string $question
     * @return ProductFaq
     */
    public function setQuestion(string $question)
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
     * @param string $answer
     * @return ProductFaq
     */
    public function setAnswer(string $answer)
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
     * @param bool $isListed
     * @return ProductFaq
     */
    public function setIsListed(bool $isListed)
    {
        return $this->setData(ProductFaqInterface::IS_LISTED, $isListed);
    }
}
