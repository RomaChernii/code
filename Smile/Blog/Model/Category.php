<?php

namespace Smile\Blog\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Smile\Blog\Api\Data\CategoryInterface;

class Category  extends AbstractModel implements CategoryInterface, IdentityInterface
{
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;
    const CACHE_TAG = 'blog_category';

    protected $_cacheTag = 'blog_category';

    protected $_eventPrefix = 'blog_category';

    protected function _construct()
    {
        $this->_init('Smile\Blog\Model\ResourceModel\Category');
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
}