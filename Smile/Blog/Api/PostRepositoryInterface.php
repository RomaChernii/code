<?php

namespace Smile\Blog\Api;

use Smile\Blog\Api\Data\PostInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface PostRepositoryInterface
{
    public function save(PostInterface $post);

    public function getById($postId);

    public function getList(SearchCriteriaInterface $criteria);

    public function delete(PostInterface $post);

    public function deleteById($postId);
}
