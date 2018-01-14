<?php

namespace Smile\Users\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Smile\Users\Api\Data\LogInterface;

class Users  extends AbstractModel implements LogInterface, IdentityInterface
{
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;
    const CACHE_TAG = 'users_log';

    protected $_cacheTag = 'users_log';

    protected $_eventPrefix = 'users_log';

    protected function _construct()
    {
        $this->_init('Smile\Users\Model\ResourceModel\Users');
    }
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }
    public function getId()
    {
        return $this->getData(self::USER_ID);
    }

    public function getLastname()
    {
        return $this->getData(self::LASTNAME);
    }

    public function getEmail()
    {
        return $this->getData(self::EMAIL);
    }

    public function getPassword()
    {
        return $this->getData(self::PASSWORD);
    }

    public function setId($id)
    {
        return $this->setData(self::USER_ID, $id);
    }

    public function setLastname($lastname)
    {
        return $this->setData(self::LASTNAME, $lastname);
    }

    public function setEmail($email)
    {
        return $this->setData(self::EMAIL, $email);
    }


    public function setPassword($password)
    {
        return $this->setData(self::PASSWORD, $password);
    }

   }