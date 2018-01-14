<?php
namespace Smile\Blog\Helper;

use Magento\Framework\App\Action\Action;

class Category extends \Magento\Framework\App\Helper\AbstractHelper
{

    /**
     * @var \Smile\Blog\Model\Category
     */
    protected $_category;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * Constructor
     *
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Smile\Blog\Model\Category $category
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Smile\Blog\Model\Category $category,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    )
    {
        $this->_category = $category;
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * Return a blog category from given category id.
     *
     * @param Action $action
     * @param null $categoryId
     * @return \Magento\Framework\View\Result\Page|bool
     */
    public function prepareResultCategory(Action $action, $categoryId = null)
    {
        if ($categoryId !== null && $categoryId !== $this->_category->getId()) {
            $delimiterPosition = strrpos($categoryId, '|');
            if ($delimiterPosition) {
                $categoryId = substr($categoryId, 0, $delimiterPosition);
            }

            if (!$this->_category->load($categoryId)) {
                return false;
            }
        }

        if (!$this->_category->getId()) {
            return false;
        }

        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        // We can add our own custom page handles for layout easily.
        $resultPage->addHandle('blog_posts_index');

        // This will generate a layout handle like: blog_category_view_id_1
        // giving us a unique handle to target specific blog categories if we wish to.
        $resultPage->addPageLayoutHandles(['id' => $this->_category->getId()]);

        // Magento is event driven after all, lets remember to dispatch our own, to help people
        // who might want to add additional functionality, or filter the categories somehow!
        $this->_eventManager->dispatch(
            'smile_blog_posts_render',
            ['posts' => $this->_category, 'controller_action' => $action]
        );

        return $resultPage;
    }
}