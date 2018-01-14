<?php
namespace Smile\Blog\Controller\Adminhtml\Coment;

use Magento\Framework\App\Action\Context;
use Smile\Blog\Model\Coment;
use Smile\Blog\Model\ComentFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\App\Action\Action;
use Smile\Blog\Api\ComentRepositoryInterface;


class Form extends Action
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    protected $comentRepository;

    protected $comentFactory;

    /**
     * @param Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Context $context,
        \Magento\Framework\Registry $coreRegistry,
        DataPersistorInterface $dataPersistor,
        ComentRepositoryInterface $comentRepository,
        ComentFactory $comentFactory

    ) {
        $this->dataPersistor = $dataPersistor;
        $this->comentRepository = $comentRepository;
        $this->comentFactory = $comentFactory;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    /**
     * Checking file for moving and move it
     *
     * @param string $imageName
     *
     * @return string
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     */

    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            $comentId = $this->getRequest()->getParam('id');

            if (isset($data['is_active']) && $data['is_active'] === 'true') {
                $data['is_active'] = Coment::STATUS_ENABLED;
            }
            if (empty($data['id'])) {
                $data['id'] = null;
            }
            if (!$comentId) {
                $model = $this->comentFactory->create();
                $model->setData($data);
                $this->comentRepository->save($model);
                $this->messageManager->addError(__('This coment no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }
            $model = $this->comentRepository->getById($comentId);

            $model->setData($data);


            try {
                $model = $this->comentRepository->getById($comentId);
                $model->setData($data);
                $this->messageManager->addSuccess(__('You saved the Coment.'));
                $this->dataPersistor->clear('blog_coment');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getById()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the coment.'));
            }

            $this->dataPersistor->set('blog_coment', $data);

            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
