<?php

namespace Smile\Blog\Model\ResourceModel;

use \Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class PostCategory extends AbstractDb
{

    protected function _construct()
    {
        $this->_init('post_categories', 'id');
    }

}