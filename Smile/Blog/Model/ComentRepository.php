<?php

namespace Smile\Blog\Model;

use Smile\Blog\Api\Data;
use Smile\Blog\Api\ComentRepositoryInterface;
use Smile\Blog\Model\ResourceModel\Coment as ResourceComent;
use Smile\Blog\Model\ResourceModel\Coment\CollectionFactory as ComentCollectionFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class ComentRepository implements ComentRepositoryInterface
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
    protected $comentFactory;

    /**
     * Speaker collection factory
     *
     * @var BlogCollectionFactory
     */
    protected $comentCollectionFactory;

    /**
     * Speaker search results interface
     *
     * @var Data\SpeakerSearchResultsInterfaceFactory
     */
    protected $comentResultsFactory;

    /**
     * Constructor
     *
     * @param ResourceBlog                          $resource                 Resource speaker model
     * @param BlogFactory                            $speakerFactory           Speaker factory
     * @param BlogrCollectionFactory                  $speakerCollectionFactory Speaker Collection factory
     * @param Data\BlogSearchResultsInterfaceFactory $searchResultsFactory     Search results factory
     */
    public function __construct(
        ResourceComent $resource,
        ComentFactory $comentFactory,
        ComentCollectionFactory $comentCollectionFactory,
        Data\ComentSearchResultsInterfaceFactory $comentResultsFactory
    ) {
        $this->resource = $resource;
        $this->comentFactory = $comentFactory;
        $this->comentCollectionFactory = $comentCollectionFactory;
        $this->comentResultsFactory = $comentResultsFactory;
    }

    /**
     * Save Speaker
     *
     * @param Data\BlogInterface $speaker
     * @return Data\BlogInterface
     * @throws CouldNotSaveException
     */
    public function save(Data\ComentInterface $coment)
    {
        try {
            $this->resource->save($coment);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $coment;
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
        $coment = $this->comentFactory->create();
        $this->resource->load($coment, $id);
        if (!$coment->getId()) {
            throw new NoSuchEntityException(__('Post with id "%1" does not exist.', $id));
        }
        return $coment;
    }

    public function getByPostId($postId)
    {
        $coment = $this->comentFactory->create();
        $this->resource->load($coment, $postId);
        if (!$coment->getPostId()) {
            throw new NoSuchEntityException(__('Post with id "%1" does not exist.', $postId));
        }
        return $coment;
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

        $collection = $this->comentCollectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }
        $searchResults->setTotalCount($collection->getSize());
        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());
        $coment = [];
        /** @var Data\SpeakerInterface $speakerModel */
        foreach ($collection as $comentModel) {
            $coment[] = $comentModel;
        }
        $searchResults->setItems($coment);
        return $searchResults;
    }

    /**
     * Delete speaker
     *
     * @param Data\BlogInterface $speaker
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(Data\ComentInterface $coment)
    {
        try {
            $this->resource->delete($coment);
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
