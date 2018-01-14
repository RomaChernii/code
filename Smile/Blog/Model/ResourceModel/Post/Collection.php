<?php

namespace Smile\Blog\Model\ResourceModel\Post;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'id';

    protected function _construct()
    {
        $this->_init('Smile\Blog\Model\Post', 'Smile\Blog\Model\ResourceModel\Post');
    }

}
