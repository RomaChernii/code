<?php
namespace Smile\Blog\Block;

use Smile\Blog\Api\Data\CategoryInterface;
use Smile\Blog\Model\ResourceModel\Category\Collection as CategoryCollection;
use Magento\Framework\View\Element\Template;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\View\Element\Template\Context;
use Smile\Blog\Model\ResourceModel\Category\CollectionFactory;
use Smile\Blog\Model\Category;

class CategoryList extends Template implements IdentityInterface
{
    /**
     * @var \Smile\Blog\Model\ResourceModel\Category\CollectionFactory
     */
    protected $_categoryCollectionFactory;

    /**
     * Construct
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Smile\Blog\Model\ResourceModel\Category\CollectionFactory $postCollectionFactory,
     * @param array $data
     */
    public function __construct(
        Context $context,
        CollectionFactory $categoryCollectionFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_categoryCollectionFactory = $categoryCollectionFactory;
    }

    /**
     * @return \Smile\Blog\Model\ResourceModel\Post\Collection
     */
    public function getCategories()
    {
        if (!$this->hasData('categories')) {
            $categories = $this->_categoryCollectionFactory->create()->addOrder(
                CategoryInterface::DESCRIPTION,
                CategoryCollection::SORT_ORDER_DESC
                )->addOrder(
                CategoryInterface::IMAGE,
                CategoryCollection::SORT_ORDER_DESC
               );
            $this->setData('categories', $categories);
        }
        return $this->getData('categories');
    }

    /**
     * Return identifiers for produced content
     *
     * @return array
     */
    public function getIdentities()
    {
        return [Category::CACHE_TAG . '_' . 'list'];
    }

}