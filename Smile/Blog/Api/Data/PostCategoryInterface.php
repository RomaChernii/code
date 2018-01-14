<?php

namespace Smile\Blog\Api\Data;


interface PostCategoryInterface
{
    const ID = 'id';
    const POST_ID = 'post_id';
    const CATEGORY_ID = 'category_id';

    public function getId();

    public function getPostId();

    public function getCategoryId();

    public function setId($id);

    public function setPostId($postId);

    public function setCategoryId($categoryId);

}