<?php
namespace Smile\Blog\Controller\Adminhtml\Post;

use Magento\Backend\App\Action;
use Smile\Blog\Api\PostRepositoryInterface;

class Delete extends Action
{
    protected $_model;

    /**
     * @param Action\Context $context
     * @param Smile\Blog\Api\PostRepositoryInterface; $model
     */
    public function __construct(
        Action\Context $context,
        PostRepositoryInterface $model
    ) {
        parent::__construct($context);
        $this->_model = $model;
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Smile_Blog::posts_delete');
    }

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $postId = $this->getRequest()->getParam('id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($postId) {
            try {
                $model = $this->_model;
                $model->deleteById($postId);
                $this->messageManager->addSuccess(__('Post deleted'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['id' => $postId]);
            }
        }
        $this->messageManager->addError(__('Post does not exist'));
        return $resultRedirect->setPath('*/*/');
    }
}