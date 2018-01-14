<?php

namespace Smile\Blog\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Smile\Blog\Api\Data\PostInterface;

class Post  extends AbstractModel implements PostInterface, IdentityInterface
{
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;
    const CACHE_TAG = 'blog_post';

    protected $_cacheTag = 'blog_post';

    protected $_eventPrefix = 'blog_post';

    protected function _construct()
    {
        $this->_init('Smile\Blog\Model\ResourceModel\Post');
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

    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    public function getImage()
    {
        return $this->getData(self::IMAGE);
    }

    public function getDescription()
    {
        return $this->getData(self::DESCRIPTION);
    }

    public function getContent()
    {
        return $this->getData(self::CONTENT);
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

    public function setTitle($title)
    {
        return $this->setData(self::TITLE, $title);
    }

    public function setImage($image)
    {
        return $this->setData(self::IMAGE, $image);
    }

    public function setDescription($description)
    {
        return $this->setData(self::DESCRIPTION, $description);
    }

    public function setContent($content)
    {
        return $this->setData(self::CONTENT, $content);
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