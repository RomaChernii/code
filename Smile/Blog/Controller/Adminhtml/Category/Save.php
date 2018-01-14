<?php
namespace Smile\Blog\Controller\Adminhtml\Category;

use Magento\Backend\App\Action\Context;
use Smile\Blog\Model\Category;
use Smile\Blog\Model\CategoryFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Backend\App\Action;
use Smile\Blog\Model\Category\ImageUploader;
use Smile\Blog\Api\CategoryRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;


class Save extends Action
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    protected $categoryRepository;

    protected $imageUploader;

    protected $categoryFactory;

    /**
     * @param Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Context $context,
        \Magento\Framework\Registry $coreRegistry,
        DataPersistorInterface $dataPersistor,
        ImageUploader $imageUploader,
        CategoryRepositoryInterface $categoryRepository,
        CategoryFactory $categoryFactory

    )
    {
        $this->dataPersistor = $dataPersistor;
        $this->imageUploader = $imageUploader;
        $this->categoryRepository = $categoryRepository;
        $this->categoryFactory = $categoryFactory;
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
            if (is_array($data['image'])) {
                $this->imageUploader->moveFileFromTmp($data['image'][0]['name']);
                $imageName = $data['image'][0]['name'];

                unset($data['image']);

                $data['image'] = 'blog/category/' . $imageName;
            }


            $categoryId = $this->getRequest()->getParam('id');

            try {
                if (!$categoryId) {
                    $model = $this->categoryFactory->create();
                    $data['id']= null;
                } else {
                    $model = $this->categoryRepository->getById($categoryId);
                }
                $model->setData($data);
                $this->categoryRepository->save($model);
                $this->messageManager->addSuccess(__('You saved the Category.'));
                $this->dataPersistor->clear('blog_category');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getById()]);
                }
                return $resultRedirect->setPath('*/*/');
            }
            catch
            (NoSuchEntityException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the category.'));
            }

            $this->dataPersistor->set('blog_category', $data);

            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}




