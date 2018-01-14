<?php

namespace Smile\Blog\Api;

use Smile\Blog\Api\Data\PostCategoryInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface PostCategoryRepositoryInterface
{
    public function save(PostCategoryInterface $category);

    public function getById($id);

    public function getList(SearchCriteriaInterface $criteria);

    public function delete(PostCategoryInterface $category);

    public function deleteById($id);
}
