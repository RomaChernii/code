<?php
namespace Smile\AdvancedRouting\Controller\Adminhtml\School;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action;

class Index extends Action
{
    const ADMIN_RESOURCE = 'Smile_AdvancedRouting::school';

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
        $resultPage->setActiveMenu('Smile_AdvancedRouting::school');
        $resultPage->addBreadcrumb(__('AdvancedRouting:'), __('AdvancedRouting:'));
        $resultPage->addBreadcrumb(__('Manage School'), __('Manage School'));
        $resultPage->getConfig()->getTitle()->prepend(__('School'));

        return $resultPage;
    }
}