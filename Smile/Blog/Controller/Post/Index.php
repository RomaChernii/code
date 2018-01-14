<?php
namespace Smile\Blog\Controller\Post;

use Magento\Framework\App\Action\Action;
use Smile\Blog\Model\Post;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\ForwardFactory;
use Magento\Framework\View\Result\PageFactory;


class Index extends Action
{
    protected $resultPageFactory;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     */
    public function __construct(
        Context $context,
        ForwardFactory $resultForwardFactory
    )
    {
        $this->resultForwardFactory = $resultForwardFactory;
        parent::__construct($context);
    }

    /**
     * Blog Index, shows a list of recent blog posts.
     *
     * @return \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
        $post_id = $this->getRequest()->getParam('post_id', $this->getRequest()->getParam('id', false));
        /** @var \Smile\Blog\Helper\Post $post_helper */
        $post_helper = $this->_objectManager->get('Smile\Blog\Helper\Post');
        $result_page = $post_helper->prepareResultPost($this, $post_id);
        if (!$result_page) {
            $resultForward = $this->resultForwardFactory->create();
            return $resultForward->forward('noroute');
        }
        return $result_page;
    }
}