<?php

declare(strict_types=1);

namespace Inchoo\ProductFaq\Model;

use Inchoo\ProductFaq\Api\Data\ProductFaqInterface;
use Inchoo\ProductFaq\Model\ResourceModel\ProductFaq as ResourceModel;
use Magento\Catalog\Model\Product;
use Magento\Framework\App\Area;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\AbstractModel;

class ProductFaq extends AbstractModel implements ProductFaqInterface, IdentityInterface
{
    /**
     * Inchoo\ProductFaq\Model\ProductFaq constructor.
     * @return void
     */
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
        return $this->_getData(ProductFaqInterface::PRODUCT_ID);
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

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->_getData(ProductFaqInterface::CREATED_AT);
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->_getData(ProductFaqInterface::UPDATED_AT);
    }

    /**
     * Return unique ID(s) for each object in system
     *
     * @return string[]
     * @throws LocalizedException
     */
    public function getIdentities(): array
    {
        $isUpdated = $this->getOrigData() != $this->getData() && !$this->isObjectNew();

        if ($this->_appState->getAreaCode() == Area::AREA_ADMINHTML && $isUpdated) {
            return [Product::CACHE_TAG . '_' . $this->getProductId()];
        }

        return [];
    }

    /**
     * Get list of cache tags applied to model object.
     *
     * Return false if cache tags are not supported by model
     *
     * @return array|bool
     * @throws LocalizedException
     */
    public function getCacheTags()
    {
        $identities = $this->getIdentities();
        return !empty($identities) ? (array) $identities : parent::getCacheTags();
    }
}
