<?php

namespace Smile\Blog\Api\Data;


interface ComentInterface
{
    const ID = 'id';
    const POST_ID = 'post_id';
    const CREATED= 'created';
    const UPDATED = 'updated';
    const USER = 'user';
    const TEXT = 'text';

    public function getId();

    public function getPostId();

    public function getCreated();

    public function getUpdated();

    public function getUser();

    public function getText();

    public function setId($id);

    public function setPostId($postId);

    public function setCreated($created);

    public function setUpdated($updated);

    public function setUser($user);

    public function setText($text);
}