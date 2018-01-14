<?php

namespace Smile\Logtest\Model;

use Smile\Logtest\Api\RepositoryInterface;

class RepositoryModel implements RepositoryInterface
{

    public function save(\Smile\Logtest\Api\Data\UserInterface $user)
    {
    //your code
    }

    public function getById($id)
    {
    //your code
    }

    public function delete(\Smile\Logtest\Api\Data\UserInterface  $user)
    {
    //your code
    }

    public function deleteById($id)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $user = $objectManager->create('Smile\Login\Model\User');
        $user->load($id)->delete();
    }
}