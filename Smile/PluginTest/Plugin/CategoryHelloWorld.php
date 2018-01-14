<?php
namespace Smile\PluginTest\Plugin;


class CategoryHelloWorld
{
    public function beforeExecute(\Smile\Blog\Controller\Index\Index $subject)
    {
        var_dump('Hello World');die;
    }
}