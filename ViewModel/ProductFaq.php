<?php

declare(strict_types=1);

namespace Inchoo\ProductFaq\ViewModel;

use Magento\Customer\Model\Session;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class ProductFaq implements ArgumentInterface
{
    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var Session
     */
    protected $session;

    /**
     * ProductFaq constructor.
     * @param RequestInterface $request
     * @param Session $session
     */
    public function __construct(
        RequestInterface $request,
        Session $session
    ) {
        $this->request = $request;
        $this->session = $session;
    }

    /**
     * @return bool
     */
    public function isLoggedIn(): bool
    {
        return $this->session->isLoggedIn();
    }

    /**
     * @return string|null
     */
    public function getProductId(): ?string
    {
        return $this->request->getParam('id');
    }

    /**
     * @return string|null
     */
    public function getCustomerId(): ?string
    {
        return $this->session->getId();
    }
}
