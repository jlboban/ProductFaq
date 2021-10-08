<?php

declare(strict_types=1);

namespace Inchoo\ProductFaq\Ui\Component\Form\Control;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class ProductFaqDeleteButton implements ButtonProviderInterface
{
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * productFaqDeleteButton constructor.
     * @param UrlInterface $urlBuilder
     * @param RequestInterface $request
     */
    public function __construct(UrlInterface $urlBuilder, RequestInterface $request)
    {
        $this->urlBuilder = $urlBuilder;
        $this->request = $request;
    }

    /**
     * @return array
     */
    public function getButtonData()
    {
        $data = [];

        if ($id = $this->request->getParam('id')) {
            $message = __('Are you sure you want to delete this FAQ?');
            $url = $this->urlBuilder->getUrl('*/*/delete');
            $data = "{data: {id: {$id}}}";

            $data = [
                'label' => __('Delete'),
                'class' => 'delete',
                'on_click' => sprintf("deleteConfirm('%s', '%s', %s)", $message, $url, $data)
            ];
        }

        return $data;
    }
}
