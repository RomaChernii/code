<?php

namespace Smile\Dev\Block;

use Magento\Framework\View\Element\Template;

class Products extends Template
{
    public function getProducts()
    {
        return ('All Products');
    }
}
