<?php
namespace Smile\Blog\Block\Adminhtml\Category\Edit;

use Magento\Backend\Block\Widget\Context;
use Smile\Blog\Api\CategoryRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class GenericButton
 */
class GenericButton
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var QuestionRepositoryInterface
     */
    protected $categoryRepository;

    /**
     * @param Context $context
     * @param QuestionRepositoryInterface $questionRepository
     */
    public function __construct(
        Context $context,
        CategoryRepositoryInterface $categoryRepository
    ) {
        $this->context = $context;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Return CMS block ID
     *
     * @return int|null
     */
    public function getCategoryId()
    {
        try {
            return $this->categoryRepository->getById(
                $this->context->getRequest()->getParam('id')
            )->getId();
        } catch (NoSuchEntityException $e) {
        }
        return null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
