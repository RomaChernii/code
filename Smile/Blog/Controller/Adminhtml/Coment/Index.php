<?php
namespace Smile\Blog\Controller\Adminhtml\Coment;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action;

class Index extends Action
{
    const ADMIN_RESOURCE = 'Smile_Login::coments';

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
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Smile_Login::coments');
        $resultPage->addBreadcrumb(__('Smile'), __('Smile'));
        $resultPage->addBreadcrumb(__('Manage Coments'), __('Manage Coments'));
        $resultPage->getConfig()->getTitle()->prepend(__('Coments'));

        return $resultPage;
    }
}
