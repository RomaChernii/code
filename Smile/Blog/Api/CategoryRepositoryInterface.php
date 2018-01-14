<?php

namespace Smile\Blog\Api;

use Smile\Blog\Api\Data\CategoryInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface CategoryRepositoryInterface
{
    public function save(CategoryInterface $category);

    public function getById($id);

    public function getList(SearchCriteriaInterface $criteria);

    public function delete(CategoryInterface $category);

    public function deleteById($id);
}
