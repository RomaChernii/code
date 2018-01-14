<?php

namespace Smile\Image\Controller\Json;

use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;


class Index extends Action
{
    protected $jsonFactory;

    public function __construct(
        Context $context,
        JsonFactory $jsonFactory
    ) {
        $this->jsonFactory = $jsonFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $jsonResult = $this->jsonFactory->create();
        $responseData = [
            'firstname' => 'Roma',
            'lastname' => 'Chernii',
            'age' => 20,
            'multipul' => [
                'test1' => 'test1',
                'test2' => 'test2'
            ]
        ];
        $jsonResult->setData($responseData);
        if ($this->getRequest()->getParam('color') == 'black')
        {
            echo 'Invalid param color';
        }
        else
        {
            return $jsonResult;
        }
    }
}


