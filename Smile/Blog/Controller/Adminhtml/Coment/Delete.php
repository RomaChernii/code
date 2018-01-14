<?php
namespace Smile\Blog\Controller\Adminhtml\Coment;

use Magento\Backend\App\Action;
use Smile\Blog\Api\ComentRepositoryInterface;


class Delete extends Action
{
    protected $_model;

    /**
     * @param Action\Context $context
     * @param Smile\Blog\Api\ComentRepositoryInterface; $model
     */
    public function __construct(
        Action\Context $context,
        ComentRepositoryInterface $model
    ) {
        parent::__construct($context);
        $this->_model = $model;
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Smile_Blog::coments_delete');
    }

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $comentId = $this->getRequest()->getParam('id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($comentId) {
            try {
                $model = $this->_model;
                $model->deleteById($comentId);
                $this->messageManager->addSuccess(__('Coment deleted'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['id' => $comentId]);
            }
        }
        $this->messageManager->addError(__('Coment does not exist'));
        return $resultRedirect->setPath('*/*/');
    }
}