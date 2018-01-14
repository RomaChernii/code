<?php

namespace Smile\Blog\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Smile\Blog\Api\Data\ComentInterface;

class Coment  extends AbstractModel implements ComentInterface, IdentityInterface
{
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;
    const CACHE_TAG = 'blog_coment';

    protected $_cacheTag = 'blog_coment';

    protected $_eventPrefix = 'blog_coment';

    protected function _construct()
    {
        $this->_init('Smile\Blog\Model\ResourceModel\Coment');
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

    public function getUser()
    {
        return $this->getData(self::USER);
    }

    public function getText()
    {
        return $this->getData(self::TEXT);
    }

    public function getCreated()
    {
        return $this->getData(self::CREATED);
    }

    public function getUpdated()
    {
        return $this->getData(self::UPDATED);
    }

    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }

    public function setPostId($postId)
    {
        return $this->setData(self::POST_ID, $postId);
    }

    public function setUser($user)
    {
        return $this->setData(self::USER, $user);
    }

    public function setText($text)
    {
        return $this->setData(self::TEXT, $text);
    }

    public function setCreated($created)
    {
        return $this->setData(self::CREATED, $created);
    }

    public function setUpdated($updated)
    {
        return $this->setData(self::UPDATED, $updated);
    }

}