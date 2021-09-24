<?php

declare(strict_types=1);

namespace Inchoo\ProductFaq\Controller\Adminhtml\ProductFaq;

use Inchoo\ProductFaq\Model\ProductFaqRepository;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;

class Delete extends Action
{
    const ADMIN_RESOURCE = 'Inchoo_ProductFaq::delete';

    /**
     * @var ProductFaqRepository
     */
    protected $productFaqRepository;

    /**
     * Delete constructor.
     * @param ProductFaqRepository $productFaqRepository
     * @param Context $context
     */
    public function __construct(ProductFaqRepository $productFaqRepository, Context $context)
    {
        $this->productFaqRepository = $productFaqRepository;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setPath('*/*/grid');

        if (!$id = $this->getRequest()->getParam('id')) {
            $this->messageManager->addErrorMessage(__('Wrong FAQ id.'));
            return $resultRedirect;
        }

        try {
            $this->productFaqRepository->deleteById((int)$id);
            $this->messageManager->addSuccessMessage(__('FAQ successfully deleted.'));
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        return $resultRedirect;
    }
}
