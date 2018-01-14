<?php
namespace Smile\Blog\Block\Adminhtml\Coment\Edit;

use Magento\Backend\Block\Widget\Context;
use Smile\Blog\Api\ComentRepositoryInterface;
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
    protected $comentRepository;

    /**
     * @param Context $context
     * @param QuestionRepositoryInterface $questionRepository
     */
    public function __construct(
        Context $context,
        ComentRepositoryInterface $comentRepository
    ) {
        $this->context = $context;
        $this->comentRepository = $comentRepository;
    }

    /**
     * Return CMS block ID
     *
     * @return int|null
     */
    public function getComentId()
    {
        try {
            return $this->comentRepository->getById(
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
