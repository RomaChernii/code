<?php

namespace Smile\Products\Block;

use Magento\Framework\View\Element\Template;

class HelloWorld extends Template
{
    public function getHelloMassage()
    {
        return ('Hello World');
    }
}