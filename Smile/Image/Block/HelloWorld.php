<?php

namespace Smile\Image\Block;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Template\Context;
use Magento\Contact\Block\ContactForm;

class HelloWorld extends ContactForm
{
    protected $urlInterface;

    public function __construct(
        Context $context,
        UrlInterface $urlInterface,
        array $data
    ) {
        $this->urlInterface = $urlInterface;
        parent::__construct($context, $data);
    }

    public function getCurrentUrl()
    {
        return $this->urlInterface->getCurrentUrl();
    }
}