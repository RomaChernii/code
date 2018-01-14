<?php

namespace Smile\Blog\Api\Data;


interface PostInterface
{
    const ID = 'id';
    const TITLE = 'title';
    const IMAGE = 'image';
    const DESCRIPTION = 'description';
    const CONTENT = 'content';
    const CREATED = 'created';
    const UPDATED = 'updated';

    public function getId();

    public function getTitle();

    public function getImage();

    public function getDescription();

    public function getContent();

    public function getCreated();

    public function getUpdated();

    public function setId($id);

    public function setTitle($title);

    public function setImage($image);

    public function setDescription($description);

    public function setContent($content);

    public function setCreated($created);

    public function setUpdated($updated);
}