<?php

namespace Smile\Blog\Model;

use Smile\Blog\Api\Data;
use Smile\Blog\Api\CategoryRepositoryInterface;
use Smile\Blog\Model\ResourceModel\Category as ResourceCategory;
use Smile\Blog\Model\ResourceModel\Category\CollectionFactory as CategoryCollectionFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Reflection\DataObjectProcessor;

class CategoryRepository implements CategoryRepositoryInterface
{
    /**
     * Speaker resource model
     *
     * @var ResourceBlog
     */
    protected $resource;

    /**
     * Speaker resource factory
     *
     * @var ResourceBlogFactory
     */
    protected $categoryFactory;

    /**
     * Speaker collection factory
     *
     * @var BlogCollectionFactory
     */
    protected $categoryCollectionFactory;

    /**
     * Speaker search results interface
     *
     * @var Data\SpeakerSearchResultsInterfaceFactory
     */
    protected $categoryResultsFactory;

    protected $searchResultsFactory;

    protected $dataObjectHelper;

    protected $dataObjectProcessor;

    /**
     * Constructor
     *
     * @param ResourceBlog                          $resource                 Resource speaker model
     * @param BlogFactory                            $speakerFactory           Speaker factory
     * @param BlogrCollectionFactory                  $speakerCollectionFactory Speaker Collection factory
     * @param Data\BlogSearchResultsInterfaceFactory $searchResultsFactory     Search results factory
     */
    public function __construct(
        ResourceCategory $resource,
        CategoryFactory $categoryFactory,
        CategoryCollectionFactory $categoryCollectionFactory,
        Data\CategorySearchResultsInterfaceFactory $categoryResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor
    ) {
        $this->resource = $resource;
        $this->categoryFactory = $categoryFactory;
        $this->categoryCollectionFactory = $categoryCollectionFactory;
        $this->categoryResultsFactory = $categoryResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataObjectProcessor = $dataObjectProcessor;
    }

    /**
     * Save Speaker
     *
     * @param Data\BlogInterface $speaker
     * @return Data\BlogInterface
     * @throws CouldNotSaveException
     */
    public function save(Data\CategoryInterface $category)
    {
        try {
            $this->resource->save($category);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $category;
    }

    /**
     * Load speaker data by given speaker identity
     *
     * @param string $entityId
     * @return Blog
     * @throws NoSuchEntityException
     */
    public function getById($id)
    {
        $category = $this->categoryFactory->create();
        $this->resource->load($category, $id);
        if (!$category->getId()) {
            throw new NoSuchEntityException(__('Category with id "%1" does not exist.', $id));
        }
        return $category;
    }
    /**
     * Load speaker data collection by given search criteria
     *
     * @param SearchCriteriaInterface $criteria
     * @return \Smile\Blog\Model\ResourceModel\Category\Collection
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function getList(SearchCriteriaInterface $criteria)
    {
        $collection = $this->categoryCollectionFactory->create();
        $categoryResultsFactory = $this->categoryResultsFactory->create();
        $categoryResultsFactory->setSearchCriteria($criteria);

        foreach ($criteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }
        $categoryResultsFactory->setTotalCount($collection->getSize());
        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());
        $category = [];
        /** @var Data\SpeakerInterface $speakerModel */
        foreach ($collection as $categoryModel) {
            $category[] = $categoryModel;
        }
        $categoryResultsFactory->setItems($category);
        return $categoryResultsFactory;
    }

    /**
     * Delete speaker
     *
     * @param Data\BlogInterface $speaker
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(Data\CategoryInterface $category)
    {
        try {
            $this->resource->delete($category);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * Delete speaker by given identity
     *
     * @param string $entityId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($id)
    {
        return $this->delete($this->getById($id));
    }
}
