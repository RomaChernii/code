<?php
namespace Smile\Dev\Controller\Adminhtml\Products;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action;

class Index extends Action
{
    const ADMIN_RESOURCE = 'Smile_Dev::products';

    protected $resultPageFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Smile_Dev::dev');
        $resultPage->addBreadcrumb(__('Dev'), __('Dev'));
        $resultPage->addBreadcrumb(__('Manage Products'), __('Manage Products'));
        $resultPage->getConfig()->getTitle()->prepend(__('Products'));

        return $resultPage;
    }
}