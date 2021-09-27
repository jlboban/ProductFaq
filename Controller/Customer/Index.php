<?php

declare(strict_types=1);

namespace Inchoo\ProductFaq\Controller\Customer;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\Page;

class Index implements HttpGetActionInterface
{
    /**
     * @var ResultFactory
     */
    protected $resultFactory;

    /**
     * @var Session
     */
    protected $session;

    public function __construct(ResultFactory $resultFactory, Session $session)
    {
        $this->resultFactory = $resultFactory;
        $this->session = $session;
    }

    /**
     * Render my product frequently asked questions
     *
     * @return Page
     */
    public function execute()
    {
        $this->session->authenticate();

        /** @var Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        if ($navigationBlock = $resultPage->getLayout()->getBlock('customer_account_navigation')) {
            $navigationBlock->setActive('faq/customer/productFaqList');
        }

        $resultPage->getConfig()->getTitle()->set(__('My Product FAQs'));

        return $resultPage;
    }
}
