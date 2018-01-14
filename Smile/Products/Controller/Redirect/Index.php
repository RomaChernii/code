<?php

namespace Smile\Products\Controller\Redirect;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\RedirectFactory;

class Index extends Action
{
    protected $redirectFactory;

    public function __construct(
        Context $context,
        RedirectFactory $redirectFactory
    ) {
        $this->redirectFactory = $redirectFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->redirectFactory->create();
        $resultRedirect->setUrl(
            $this->_url->getUrl('products/json')
        );

        return $resultRedirect;

    }
}
