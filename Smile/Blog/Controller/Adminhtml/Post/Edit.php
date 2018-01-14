<?php

namespace Smile\Blog\Controller\Adminhtml\Post;

use Smile\Blog\Api\PostRepositoryInterface;
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
    protected $postRepository;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        PageFactory $resultPageFactory,
        PostRepositoryInterface $postRepository
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->postRepository = $postRepository;
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
        $postId = $this->getRequest()->getParam('id');
        // 2. Initial checking
        if ($postId) {
            try {
                $model = $this->postRepository->getById($postId);
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addError(__('This post no longer exists.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }

            $this->coreRegistry->register('blog_post', $model);

            // 5. Build edit form
            /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
            $resultPage = $this->resultPageFactory->create();
            $resultPage->getConfig()->getTitle()->prepend(__('Post'));
            $resultPage->getConfig()->getTitle()->prepend($model->getById() ? $model->getTitle() : __('New Post'));
            $resultPage->setActiveMenu('Smile_Blog::posts')
                ->addBreadcrumb(__('Post'), __('Post'))
                ->addBreadcrumb(__('Static Post'), __('Static Post'));
            return $resultPage;
        }
        else {
            $resultPage = $this->resultPageFactory->create();
            $resultPage->getConfig()->getTitle()->prepend(__('Post'));
            $resultPage->setActiveMenu('Smile_Blog::posts')
                ->addBreadcrumb(__('Post'), __('Post'))
                ->addBreadcrumb(__('Static Post'), __('Static Post'));
            return $resultPage;
        }

    }
}
