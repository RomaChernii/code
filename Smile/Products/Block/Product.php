<?php

namespace Smile\Products\Block;

use Magento\Framework\View\Element\Template;

class Product extends Template
{
    public function getProductDescription()
    {
        return ('What\'s a little rain or snow when you\'re inside the Taurus Elements Shell? This specially engineered Cocona® jacket lets you enjoy the great outdoors and brave the elements, thanks to the all-waterproof, breathable exterior.');
    } public function getProductPrice()
    {
        return ('$65.00');
    }
}