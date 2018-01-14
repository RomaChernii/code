<?php
namespace Smile\Blog\Controller\Adminhtml\Category;

use Magento\Backend\App\Action;
use Smile\Blog\Api\CategoryRepositoryInterface;

class Delete extends Action
{
    protected $_model;

    /**
     * @param Action\Context $context
     * @param Smile\Blog\Api\CategoryRepositoryInterface; $model
     */
    public function __construct(
        Action\Context $context,
        CategoryRepositoryInterface $model
    ) {
        parent::__construct($context);
        $this->_model = $model;
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Smile_Blog::categories_delete');
    }

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $categoryId = $this->getRequest()->getParam('id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($categoryId) {
            try {
                $model = $this->_model;
                $model->deleteById($categoryId);
                $this->messageManager->addSuccess(__('Category deleted'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['id' => $categoryId]);
            }
        }
        $this->messageManager->addError(__('Category does not exist'));
        return $resultRedirect->setPath('*/*/');
    }
}