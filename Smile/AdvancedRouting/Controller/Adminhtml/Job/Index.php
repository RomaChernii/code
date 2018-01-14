<?php
namespace Smile\AdvancedRouting\Controller\Adminhtml\Job;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action;

class Index extends Action
{
    const ADMIN_RESOURCE = 'Smile_AdvancedRouting::job';

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
        $resultPage->setActiveMenu('Smile_AdvancedRouting::job');
        $resultPage->addBreadcrumb(__('Smile'), __('Smile'));
        $resultPage->addBreadcrumb(__('Manage Job'), __('Manage Job'));
        $resultPage->getConfig()->getTitle()->prepend(__('Job'));

        return $resultPage;
    }
}