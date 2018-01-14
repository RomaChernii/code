<?php

namespace Smile\Blog\Controller\Adminhtml\Category;

use Smile\Blog\Api\CategoryRepositoryInterface;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action;
use Magento\Framework\Registry;
use Magento\Framework\Exception\NoSuchEntityException;

class Edit extends Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    protected $coreRegistry;
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $categoryRepository;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        PageFactory $resultPageFactory,
        CategoryRepositoryInterface $categoryRepository
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->categoryRepository = $categoryRepository;
        $this->coreRegistry = $coreRegistry;
        parent::__construct($context);
    }

    /**
     * Edit CMS block
     *
     * @return \Magento\Framework\Controller\ResultInterface
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        // 1. Get ID and create model
        $categoryId = $this->getRequest()->getParam('id');

        // 2. Initial checking
        if ($categoryId) {
            try {
                $model = $this->categoryRepository->getById($categoryId);
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addError(__('This category no longer exists.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }

            $this->coreRegistry->register('blog_category', $model);

            // 5. Build edit form
            /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
            $resultPage = $this->resultPageFactory->create();
            $resultPage->getConfig()->getTitle()->prepend(__('Category'));
            $resultPage->getConfig()->getTitle()->prepend($model->getById() ? $model->getTitle() : __('New Category'));
            $resultPage->setActiveMenu('Smile_Blog::categories')
                ->addBreadcrumb(__('Category'), __('Category'))
                ->addBreadcrumb(__('Static Category'), __('Static Category'));
            return $resultPage;
        }
        else {
            $resultPage = $this->resultPageFactory->create();
            $resultPage->getConfig()->getTitle()->prepend(__('Category'));
            $resultPage->setActiveMenu('Smile_Blog::categories')
                ->addBreadcrumb(__('Category'), __('Category'))
                ->addBreadcrumb(__('Static Category'), __('Static Category'));
            return $resultPage;
        }

    }
}
