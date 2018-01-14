<?php

namespace Smile\Image\Block;

use Magento\Framework\View\Element\Template;

class Sale extends Template
{
    public function getSaleMassage()
    {
        return ('All discounts from shop Smile.');
    }
}