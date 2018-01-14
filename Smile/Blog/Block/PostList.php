<?php
namespace Smile\Blog\Block;

use Smile\Blog\Api\Data\PostInterface;
use Smile\Blog\Model\ResourceModel\Post\Collection as PostCollection;
use Magento\Framework\View\Element\Template;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\View\Element\Template\Context;
use Smile\Blog\Model\ResourceModel\Post\CollectionFactory;
use Smile\Blog\Model\Post;

class PostList extends Template implements IdentityInterface
{
    /**
     * @var \Ashsmith\Blog\Model\ResourceModel\Category\CollectionFactory
     */
    protected $_postCollectionFactory;

    /**
     * Construct
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Ashsmith\Blog\Model\ResourceModel\Category\CollectionFactory $postCollectionFactory,
     * @param array $data
     */
    public function __construct(
        Context $context,
        Post $post,
        \Smile\Blog\Model\PostFactory $postFactory,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->_post = $post;
        $this->_postFactory = $postFactory;
    }

    /**
     * @return \Smile\Blog\Model\Post
     */
    public function getPosts()
    {
        // Check if posts has already been defined
        // makes our block nice and re-usable! We could
        // pass the 'posts' data to this block, with a collection
        // that has been filtered differently!
        if (!$this->hasData('post')) {
            if ($this->getPostId()) {
                /** @var \Smile\Blog\Model\Post $page */
                $post = $this->_postFactory->create();
            } else {
                $post = $this->_post;
            }
            $this->setData('post', $post);
        }
        return $this->getData('post');
    }

    /**
     * Return identifiers for produced content
     *
     * @return array
     */
    public function getIdentities()
    {
        return [Post::CACHE_TAG . '_' . $this->getPost()->getId()];
    }

}