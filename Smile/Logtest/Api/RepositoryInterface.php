<?php

namespace Smile\Logtest\Api;

interface RepositoryInterface
{

    public function save(\Smile\Logtest\Api\Data\UserInterface $user);

    public function getById($userId);

    public function delete(\Smile\Logtest\Api\Data\UserInterface $user);

    public function deleteById($userId);
}
