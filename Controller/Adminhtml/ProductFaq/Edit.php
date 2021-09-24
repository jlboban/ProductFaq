<?php

declare(strict_types=1);

namespace Inchoo\ProductFaq\Controller\Adminhtml\ProductFaq;

use Inchoo\ProductFaq\Model\ProductFaqRepository;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;

class Edit extends Action implements HttpGetActionInterface
{
    const ADMIN_RESOURCE = 'Inchoo_ProductFaq::edit';

    /**
     * @var ProductFaqRepository
     */
    protected $productFaqRepository;

    /**
     * Edit constructor.
     * @param ProductFaqRepository $productFaqRepository
     * @param Context $context
     */
    public function __construct(
        ProductFaqRepository $productFaqRepository,
        Context $context
    ) {
        $this->productFaqRepository = $productFaqRepository;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $title = __('Product FAQ Form');

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu('Inchoo_ProductFaq::productFaq');
        $resultPage->addBreadcrumb($title, $title);
        $resultPage->getConfig()->getTitle()->prepend($title);

        return $resultPage;
    }
}
