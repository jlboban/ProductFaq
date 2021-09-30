<?php

declare(strict_types=1);

namespace Inchoo\ProductFaq\Api\Data;

interface ProductFaqInterface
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
     * @param int|null $entityId
     * @return mixed
     */
    public function setEntityId(?int $entityId);

    /**
     * @return mixed|null
     */
    public function getProductId();

    /**
     * @param int|null $productId
     * @return mixed
     */
    public function setProductId(?int $productId);

    /**
     * @return mixed|null
     */
    public function getStoreId();

    /**
     * @param int|null $storeId
     * @return mixed
     */
    public function setStoreId(?int $storeId);

    /**
     * @return mixed|null
     */
    public function getCustomerId();

    /**
     * @param int|null $customerId
     * @return mixed
     */
    public function setCustomerId(?int $customerId);

    /**
     * @return mixed|null
     */
    public function getQuestion();

    /**
     * @param string|null $question
     * @return mixed
     */
    public function setQuestion(?string $question);

    /**
     * @return mixed|null
     */
    public function getAnswer();

    /**
     * @param string|null $answer
     * @return mixed
     */
    public function setAnswer(?string $answer);

    /**
     * @return mixed|null
     */
    public function getIsListed();

    /**
     * @param bool $isListed
     * @return mixed
     */
    public function setIsListed(bool $isListed);

    /**
     * @return mixed
     */
    public function getCreatedAt();

    /**
     * @return mixed
     */
    public function getUpdatedAt();
}
