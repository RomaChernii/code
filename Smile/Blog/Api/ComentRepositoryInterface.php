<?php

namespace Smile\Blog\Api;

use Smile\Blog\Api\Data\ComentInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface ComentRepositoryInterface
{
    public function save(ComentInterface $coment);

    public function getById($id);

    public function getByPostId($postId);

    public function getList(SearchCriteriaInterface $criteria);

    public function delete(ComentInterface $coment);

    public function deleteById($id);
}
