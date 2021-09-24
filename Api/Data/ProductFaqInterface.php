<?php

declare(strict_types=1);

namespace Inchoo\ProductFaq\Api\Data;

Interface ProductFaqInterface
{
    public const ENTITY_ID = 'entity_id';
    public const PRODUCT_ID = 'product_id';
    public const STORE_ID = 'store_id';
    public const CUSTOMER_ID = 'customer_id';
    public const QUESTION = 'question';
    public const ANSWER = 'answer';
    public const IS_LISTED = 'is_listed';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

    /**
     * @return mixed
     */
    public function getEntityId();

    /**
     * @param mixed $entityId
     * @return mixed
     */
    public function setEntityId($entityId);

    /**
     * @return mixed|null
     */
    public function getProductId();

    /**
     * @param mixed $productId
     * @return mixed
     */
    public function setProductId($productId);

    /**
     * @return mixed|null
     */
    public function getStoreId();


    /**
     * @param mixed $storeId
     * @return mixed
     */
    public function setStoreId($storeId);

    /**
     * @return mixed|null
     */
    public function getCustomerId();

    /**
     * @param mixed $customerId
     * @return mixed
     */
    public function setCustomerId($customerId);

    /**
     * @return mixed|null
     */
    public function getQuestion();

    /**
     * @param mixed $question
     * @return mixed
     */
    public function setQuestion($question);

    /**
     * @return mixed|null
     */
    public function getAnswer();

    /**
     * @param mixed $answer
     * @return mixed
     */
    public function setAnswer($answer);

    /**
     * @return mixed|null
     */
    public function getIsListed();

    /**
     * @param mixed $isListed
     * @return mixed
     */
    public function setIsListed($isListed);
}
