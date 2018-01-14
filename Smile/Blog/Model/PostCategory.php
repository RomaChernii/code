<?php

namespace Smile\Blog\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Smile\Blog\Api\Data\PostCategoryInterface;

class PostCategory  extends AbstractModel implements PostCategoryInterface, IdentityInterface
{
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;
    const CACHE_TAG = 'blog_post_category';

    protected $_cacheTag = 'blog_post_category';

    protected $_eventPrefix = 'blog_post_category';

    protected function _construct()
    {
        $this->_init('Smile\Blog\Model\ResourceModel\PostCategory');
    }

    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getId()
    {
        return $this->getData(self::ID);
    }

    public function getPostId()
    {
        return $this->getData(self::POST_ID);
    }

    public function getCategoryId()
    {
        return $this->getData(self::CATEGORY_ID);
    }

    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }

    public function setPostId($postId)
    {
        return $this->setData(self::POST_ID, $postId);
    }

    public function setCategoryId($categoryId)
    {
        return $this->setData(self::CATEGORY_ID, $categoryId);
    }
}