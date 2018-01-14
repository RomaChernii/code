<?php

namespace Smile\Blog\Api\Data;


interface CategoryInterface
{
    const ID = 'id';
    const TITLE = 'title';
    const IMAGE = 'image';
    const DESCRIPTION = 'description';

    public function getId();

    public function getTitle();

    public function getImage();

    public function getDescription();

    public function setId($id);

    public function setTitle($title);

    public function setImage($image);

    public function setDescription($description);
}