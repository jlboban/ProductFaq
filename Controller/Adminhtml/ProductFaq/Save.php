<?php

declare(strict_types=1);

namespace Inchoo\ProductFaq\Controller\Adminhtml\ProductFaq;

use Inchoo\ProductFaq\Api\Data\ProductFaqInterface;
use Inchoo\ProductFaq\Model\ProductFaqFactory;
use Inchoo\ProductFaq\Model\ProductFaqRepository;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultFactory;

class Save extends Action implements HttpPostActionInterface
{
    const ADMIN_RESOURCE = 'Inchoo_ProductFaq::create';

    /**
     * @var ProductFaqRepository
     */
    protected $productFaqRepository;

    /**
     * @var ProductFaqFactory
     */
    protected $productFaqFactory;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * Save constructor.
     * @param ProductFaqRepository $productFaqRepository
     * @param ProductFaqFactory $productFaqFactory
     * @param DataPersistorInterface $dataPersistor
     * @param Context $context
     */
    public function __construct(
        ProductFaqRepository $productFaqRepository,
        ProductFaqFactory $productFaqFactory,
        DataPersistorInterface $dataPersistor,
        Context $context
    ) {
        $this->productFaqRepository = $productFaqRepository;
        $this->productFaqFactory = $productFaqFactory;
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        $request = $this->getRequest();
        $id = $request->getParam('entity_id');

        if (!$this->isDataValid()) {
            $this->messageManager->addErrorMessage(__('Form data is not valid.'));
            $this->dataPersistor->set('inchoo_productFaq', $request->getParams());
            return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
        }

        try {
            $productFaq = $id ? $this->productFaqRepository->get((int)$id) : $this->productFaqFactory->create();
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            $this->messageManager->addExceptionMessage($e);
            return $resultRedirect->setPath('*/*/grid');
        }

        $isListed = $request->getParam(ProductFaqInterface::IS_LISTED);

        $productFaq->setData('question', $request->getParam('question'));
        $productFaq->setData('answer', $request->getParam('answer'));
        $productFaq->setData('is_listed', (int) filter_var($isListed, FILTER_VALIDATE_BOOLEAN));

        try {
            $this->productFaqRepository->save($productFaq);
        } catch (\Magento\Framework\Exception\CouldNotSaveException $e) {
            $this->dataPersistor->set('inchoo_productFaq', $request->getParams());
            $this->messageManager->addExceptionMessage($e);
        }

        return $resultRedirect->setPath('*/*/edit', ['id' => $productFaq->getEntityId()]);
    }

    /**
     * @return bool
     */
    protected function isDataValid(): bool
    {
        if (!$this->getRequest()->getParam('question')) {
            return false;
        }

        return true;
    }
}
