<?php

namespace Smile\Blog\Model;

use Smile\Blog\Api\Data;
use Smile\Blog\Api\PostRepositoryInterface;
use Smile\Blog\Model\ResourceModel\Post as ResourcePost;
use Smile\Blog\Model\ResourceModel\Post\CollectionFactory as PostCollectionFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class PostRepository implements PostRepositoryInterface
{
    /**
     * Speaker resource model
     *
     * @var ResourcePost
     */
    protected $resource;

    /**
     * Speaker resource factory
     *
     * @var ResourcePostFactory
     */
    protected $postFactory;

    /**
     * Speaker collection factory
     *
     * @var PostCollectionFactory
     */
    protected $postCollectionFactory;

    /**
     * Speaker search results interface
     *
     * @var Data\SpeakerSearchResultsInterfaceFactory
     */
    protected $postResultsFactory;

    /**
     * Constructor
     *
     * @param ResourceBlog                          $resource                 Resource speaker model
     * @param BlogFactory                            $speakerFactory           Speaker factory
     * @param BlogrCollectionFactory                  $speakerCollectionFactory Speaker Collection factory
     * @param Data\BlogSearchResultsInterfaceFactory $searchResultsFactory     Search results factory
     */
    public function __construct(
        ResourcePost $resource,
        PostFactory $postFactory,
        PostCollectionFactory $postCollectionFactory,
        Data\PostSearchResultsInterfaceFactory $postResultsFactory
    ) {
        $this->resource = $resource;
        $this->postFactory = $postFactory;
        $this->postCollectionFactory = $postCollectionFactory;
        $this->postResultsFactory = $postResultsFactory;
    }

    /**
     * Save Speaker
     *
     * @param Data\BlogInterface $speaker
     * @return Data\BlogInterface
     * @throws CouldNotSaveException
     */
    public function save(Data\PostInterface $post)
    {
        try {
            $this->resource->save($post);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $post;
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
        $post = $this->postFactory->create();
        $this->resource->load($post, $id);
        if (!$post->getId()) {
            throw new NoSuchEntityException(__('Post with id "%1" does not exist.', $id));
        }
        return $post;
    }
    /**
     * Load speaker data collection by given search criteria
     *
     * @param SearchCriteriaInterface $criteria
     * @return \Smile\Blog\Model\ResourceModel\Blog\Collection
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function getList(SearchCriteriaInterface $criteria)
    {
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $collection = $this->postCollectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }
        $searchResults->setTotalCount($collection->getSize());
        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());
        $post = [];
        /** @var Data\SpeakerInterface $speakerModel */
        foreach ($collection as $postModel) {
            $post[] = $postModel;
        }
        $searchResults->setItems($post);
        return $searchResults;
    }

    /**
     * Delete speaker
     *
     * @param Data\BlogInterface $speaker
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(Data\PostInterface $post)
    {
        try {
            $this->resource->delete($post);
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
