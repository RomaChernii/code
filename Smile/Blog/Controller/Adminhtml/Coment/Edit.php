<?php

namespace Smile\Blog\Controller\Adminhtml\Coment;

use Smile\Blog\Api\ComentRepositoryInterface;
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
    protected $comentRepository;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        PageFactory $resultPageFactory,
        ComentRepositoryInterface $comentRepository
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->comentRepository = $comentRepository;
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
        $comentId = $this->getRequest()->getParam('id');

        // 2. Initial checking
        if ($comentId) {
            try {
//
                $model = $this->comentRepository->getById($comentId);
            } catch (NoSuchEntityException $e) {
                $this->messageManager->addError(__('This coment no longer exists.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }

            $this->coreRegistry->register('blog_coment', $model);

            // 5. Build edit form
            /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
            $resultPage = $this->resultPageFactory->create();
            $resultPage->getConfig()->getTitle()->prepend(__('Coment'));
            $resultPage->getConfig()->getTitle()->prepend($model->getById() ? $model->getTitle() : __('New Coment'));
            $resultPage->setActiveMenu('Smile_Blog::coments')
                ->addBreadcrumb(__('Coment'), __('Coment'))
                ->addBreadcrumb(__('Static Coment'), __('Static Coment'));
            return $resultPage;
        }
        else {
            $resultPage = $this->resultPageFactory->create();
            $resultPage->getConfig()->getTitle()->prepend(__('Coment'));
            $resultPage->setActiveMenu('Smile_Blog::coments')
                ->addBreadcrumb(__('Coment'), __('Coment'))
                ->addBreadcrumb(__('Static Coment'), __('Static Coment'));
            return $resultPage;
        }

    }
}
