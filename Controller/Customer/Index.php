<?php

declare(strict_types=1);

namespace Inchoo\ProductFaq\Controller\Customer;

use Inchoo\ProductFaq\Model\Config;
use Magento\Customer\Model\Session;
use Magento\Customer\Model\Url as CustomerUrl;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\Result\ForwardFactory;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
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
    protected $customerSession;

    /**
     * @var CustomerUrl
     */
    protected $customerUrl;

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var ForwardFactory
     */
    protected $forwardFactory;

    /**
     * Index constructor.
     * @param ResultFactory $resultFactory
     * @param Session $customerSession
     * @param CustomerUrl $customerUrl
     * @param Config $config
     * @param ForwardFactory $forwardFactory
     */
    public function __construct(
        ResultFactory $resultFactory,
        Session $customerSession,
        CustomerUrl $customerUrl,
        Config $config,
        ForwardFactory $forwardFactory
    ) {
        $this->resultFactory = $resultFactory;
        $this->customerSession = $customerSession;
        $this->customerUrl = $customerUrl;
        $this->config = $config;
        $this->forwardFactory = $forwardFactory;
    }

    /**
     * Render my product frequently asked questions
     *
     * @return ResultInterface|Redirect
     */
    public function execute()
    {
        if (!$this->config->getProductFaqActive()) {
            return $this->forwardFactory->create()->forward('noroute');
        }

        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        if (!$this->customerSession->authenticate()) {
            $resultRedirect->setPath($this->customerUrl->getLoginUrl());
            return $resultRedirect;
        }

        /** @var Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        if ($navigationBlock = $resultPage->getLayout()->getBlock('customer_account_navigation')) {
            $navigationBlock->setActive('faq/customer/productFaqList');
        }

        $resultPage->getConfig()->getTitle()->set(__('My Product FAQs'));

        return $resultPage;
    }
}
