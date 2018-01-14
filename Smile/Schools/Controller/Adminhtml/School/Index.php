<?php
namespace Smile\Schools\Controller\Adminhtml\School;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action;

class Index extends Action
{
    const ADMIN_RESOURCE = 'Smile_Schools::school';

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Index action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Smile_Schools::school');
        $resultPage->addBreadcrumb(__('Schools'), __('Schools'));
        $resultPage->addBreadcrumb(__('Manage Schools'), __('Manage Schools'));
        $resultPage->getConfig()->getTitle()->prepend(__('School'));

        return $resultPage;
    }
}