<?php

namespace Smile\Blog\Model\Post;

use Smile\Blog\Model\CategoryRepository;
use Magento\Framework\Option\ArrayInterface;
use Smile\Blog\Model\ResourceModel\Category\Collection;
use Smile\Blog\Model\ResourceModel\Category\CollectionFactory;


class PostCategory implements ArrayInterface
{
    protected $categoryRepository;

    protected $collectionFactory;

    public function __construct(
        CategoryRepository $categoryRepository,
        Collection $categoryCollection,
        CollectionFactory $collectionFactory
    )
    {
        $this->categoryRepository = $categoryRepository;
        $this->categoryCollection = $categoryCollection;
        $this->_collectionFactory = $collectionFactory;
    }

    public function toOptionArray()
    {

        $categoryCollection = $this->_collectionFactory->create();
        $options = [];
        foreach ($categoryCollection as $category) {
            $options[] = [
                'label' => $category->getTitle(),
                'value' => $category->getId()
            ];
        }
        return $options;

    }
}