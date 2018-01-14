<?php

namespace Smile\Users\Api\Data;


interface LogInterface
{
    const USER_ID = 'user_id';
    const LASTNAME = 'lastname';
    const EMAIL = 'email';
    const PASSWORD = 'password';

    public function getId();

    public function getLastname();

    public function getEmail();

    public function getPassword();

    public function setId($id);

    public function setLastname($lastname);

    public function setEmail($email);

    public function setPassword($password);

}