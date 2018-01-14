<?php

namespace Smile\Logtest\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Smile\Logtest\Api\Data\UserInterface;

class Users  extends AbstractModel implements UserInterface, IdentityInterface
{
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;
    const CACHE_TAG = 'logtest_user';

    protected $_cacheTag = 'logtestid_user';

    protected $_eventPrefix = 'logtestid_user';

    protected function _construct()
    {
        $this->_init('Smile\Logtest\Model\ResourceModel\Users');
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