<?php

namespace Smile\Blog\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface ComentSearchResultsInterface extends SearchResultsInterface
{
    public function getItems();

    public function setItems(array $items);
}
