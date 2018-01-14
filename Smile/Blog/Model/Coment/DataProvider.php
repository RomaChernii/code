<?php
namespace Smile\Blog\Model\Coment;

use Smile\Blog\Model\ResourceModel\Coment\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;

/**
 * Class DataProvider
 */
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var \Smile\ContactsPro\Model\ResourceModel\Question\Collection
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $questionCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $comentCollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $comentCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();

        foreach ($items as $coment) {
            $this->loadedData[$coment->getId()] = $coment->getData();
        }

        $data = $this->dataPersistor->get('blog_coment');
        if (!empty($data)) {
            $coment = $this->collection->getNewEmptyItem();
            $coment->setData($data);
            $this->loadedData[$coment->getId()] = $coment->getData();
            $this->dataPersistor->clear('blog_coment');
        }

        return $this->loadedData;
    }
}
