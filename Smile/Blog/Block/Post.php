<?php
namespace Smile\Blog\Block;


use Magento\Framework\View\Element\Template;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\View\Element\Template\Context;
use Smile\Blog\Model\ResourceModel\Post\CollectionFactory;
use Smile\Blog\Api\Data\ComentInterface;
use Smile\Blog\Model\ResourceModel\Coment\Collection as ComentCollection;

class Post extends Template implements IdentityInterface
{
    /**
     * @var \Smile\Blog\Model\ResourceModel\Category\CollectionFactory
     */

    protected $post;

    protected $coment;
    /**
     * Speaker resource factory
     *
     * @var ResourcePostFactory
     */
    protected $postFactory;

    protected $comentFactory;

    protected $_comentCollectionFactory;

    /**
     * Construct
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Smile\Blog\Model\ResourceModel\Category\CollectionFactory $postCollectionFactory,
     * @param array $data
     */
    public function __construct(
        Context $context,
        \Smile\Blog\Model\Post $post,
        \Smile\Blog\Model\Coment $coment,
        \Smile\Blog\Model\ComentFactory $comentFactory,
        \Smile\Blog\Model\PostFactory $postFactory,
        CollectionFactory $comentCollectionFactory,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->_post = $post;
        $this->_postFactory = $postFactory;
        $this->_coment = $coment;
        $this->_comentFactory = $comentFactory;
        $this->_comentCollectionFactory = $comentCollectionFactory;

    }

    /**
     * @return \Smile\Blog\Model\Post
     */
    public function getPost()
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

    public function getComent()
    {
        if (!$this->hasData('coments')) {
            $coments = $this->_comentCollectionFactory->create()->addOrder(
                ComentInterface::USER,
                ComentCollection::SORT_ORDER_DESC
            )->addOrder(
                ComentInterface::TEXT,
                ComentCollection::SORT_ORDER_DESC
            );
            $this->setData('coments', $coments);
        }
        return $this->getData('coments');
    }

    /**
     * Return identifiers for produced content
     *
     * @return array
     */
    public function getIdentities()
    {
        return [\Smile\Blog\Model\Post::CACHE_TAG . '_' . $this->getPost()->getId()];
    }


}