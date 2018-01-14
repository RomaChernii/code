<?php

namespace Smile\Blog\Model;

use Smile\Blog\Api\Data;
use Smile\Blog\Api\PostCategoryRepositoryInterface;
use Smile\Blog\Model\ResourceModel\PostCategory as ResourcePostCategory;
use Smile\Blog\Model\ResourceModel\PostCategory\CollectionFactory as PostCategoryCollectionFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class PostCategoryRepository implements PostCategoryRepositoryInterface
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
    protected $postCategoryFactory;

    /**
     * Speaker collection factory
     *
     * @var BlogCollectionFactory
     */
    protected $postCategoryCollectionFactory;

    /**
     * Speaker search results interface
     *
     * @var Data\SpeakerSearchResultsInterfaceFactory
     */
    protected $postCategoryResultsFactory;

    /**
     * Constructor
     *
     * @param ResourceBlog                          $resource                 Resource speaker model
     * @param BlogFactory                            $speakerFactory           Speaker factory
     * @param BlogrCollectionFactory                  $speakerCollectionFactory Speaker Collection factory
     * @param Data\BlogSearchResultsInterfaceFactory $searchResultsFactory     Search results factory
     */
    public function __construct(
        ResourcePostCategory $resource,
        PostCategoryFactory $postCategoryFactory,
        PostCategoryCollectionFactory $postCategoryCollectionFactory,
        Data\PostCategorySearchResultsInterfaceFactory $postCategoryResultsFactory
    ) {
        $this->resource = $resource;
        $this->postCategoryFactory = $postCategoryFactory;
        $this->postCategoryCollectionFactory = $postCategoryCollectionFactory;
        $this->postCategoryResultsFactory = $postCategoryResultsFactory;
    }

    /**
     * Save Speaker
     *
     * @param Data\BlogInterface $speaker
     * @return Data\BlogInterface
     * @throws CouldNotSaveException
     */
    public function save(Data\PostCategoryInterface $postCategory)
    {
        try {
            $this->resource->save($postCategory);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $postCategory;
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
        $postCategory = $this->postCategoryFactory->create();
        $this->resource->load($postCategory, $id);
        if (!$postCategory->getId()) {
            throw new NoSuchEntityException(__('Post with id "%1" does not exist.', $id));
        }
        return $postCategory;
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
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $collection = $this->postCategoryCollectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }
        $searchResults->setTotalCount($collection->getSize());
        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());
        $postCategory = [];
        /** @var Data\SpeakerInterface $speakerModel */
        foreach ($collection as $postCategoryModel) {
            $postCategory[] = $postCategoryModel;
        }
        $searchResults->setItems($postCategory);
        return $searchResults;
    }

    /**
     * Delete speaker
     *
     * @param Data\BlogInterface $speaker
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(Data\PostCategoryInterface $postCategory)
    {
        try {
            $this->resource->delete($postCategory);
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
