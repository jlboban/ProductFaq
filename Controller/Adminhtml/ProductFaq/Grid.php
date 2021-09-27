<?php

declare(strict_types=1);

namespace Inchoo\ProductFaq\Controller\Adminhtml\ProductFaq;

use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;

class Grid extends Action implements HttpGetActionInterface
{
    const ADMIN_RESOURCE = 'Inchoo_ProductFaq::view';

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu('Inchoo_ProductFaq::productFaq');
        $resultPage->addBreadcrumb(__('Product FAQ Management'), __('Product FAQ Management'));
        $resultPage->getConfig()->getTitle()->prepend(__('Product FAQ Management'));

        return $resultPage;
    }
}
