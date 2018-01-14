<?php
namespace Smile\Products\Controller\Adminhtml\HelloWorld;

use \Magento\Backend\App\Action;

class Index extends Action
{
    const ADMIN_RESOURCE = 'Smile_Products::smile';

    protected $resultPageFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Smile_Products::smile');
        $resultPage->addBreadcrumb(__('Smile'), __('Smile'));
        $resultPage->addBreadcrumb(__('Manage Smile'), __('Manage Smile'));
        $resultPage->getConfig()->getTitle()->prepend(__('Smile'));

        return  $resultPage;
    }
}

