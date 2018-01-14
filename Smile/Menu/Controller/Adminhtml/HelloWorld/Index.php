<?php
namespace Smile\Menu\Controller\Adminhtml\HelloWorld;
use \Magento\Backend\App\Action;
class Index extends Action
{
    public function execute()
    {
        echo "Hello Smile";
    }
}
