<?php
namespace Smile\Blog\Controller\Adminhtml\Post;

use Magento\Backend\App\Action\Context;
use Smile\Blog\Model\Post;
use Smile\Blog\Model\PostFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Backend\App\Action;
use Smile\Blog\Model\Post\ImageUploader;
use Smile\Blog\Api\PostRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;


class Save extends Action
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    protected $postRepository;

    protected $imageUploader;

    protected $postFactory;

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
        PostRepositoryInterface $postRepository,
        PostFactory $postFactory

    )
    {
        $this->dataPersistor = $dataPersistor;
        $this->imageUploader = $imageUploader;
        $this->postRepository = $postRepository;
        $this->postFactory = $postFactory;
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

                $data['image'] = 'blog/post/' . $imageName;
            }

            $postId = $this->getRequest()->getParam('id');

            try {
                if (!$postId) {
                    $model = $this->postFactory->create();
                    $data['id']= null;
                } else {
                    $model = $this->postRepository->getById($postId);
                }
                    $model->setData($data);
                    $this->postRepository->save($model);
                    $this->messageManager->addSuccess(__('You saved the Post.'));
                    $this->dataPersistor->clear('blog_post');

                    if ($this->getRequest()->getParam('back')) {
                        return $resultRedirect->setPath('*/*/edit', ['id' => $model->getById()]);
                    }
                    return $resultRedirect->setPath('*/*/');
                }
            catch
                (NoSuchEntityException $e) {
                    $this->messageManager->addError($e->getMessage());
                } catch (\Exception $e) {
                    $this->messageManager->addException($e, __('Something went wrong while saving the post.'));
                }

                $this->dataPersistor->set('blog_post', $data);

                return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
            }
            return $resultRedirect->setPath('*/*/');
        }
    }




