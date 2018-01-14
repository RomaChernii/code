<?php
namespace Smile\Blog\Controller\Adminhtml\Category;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action;

class Index extends Action
{
    const ADMIN_RESOURCE = 'Smile_Blog::categories';

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
        $resultPage->setActiveMenu('Smile_Blog::categories');
        $resultPage->addBreadcrumb(__('Smile'), __('Smile'));
        $resultPage->addBreadcrumb(__('Manage Categories'), __('Manage Categories'));
        $resultPage->getConfig()->getTitle()->prepend(__('Categories'));

        $dataPersistor = $this->_objectManager->get('Magento\Framework\App\Request\DataPersistorInterface');
        $dataPersistor->clear('smile_blog');

        return $resultPage;
    }
}
