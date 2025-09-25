<?php
/**
 * User: david
 * Date: 9/28/18
 * Time: 4:23 PM
 */

namespace NYX\Blog\Block\Adminhtml\Blog\Edit;

use Magento\Backend\Block\Widget\Context;
use NYX\Blog\Api\PostRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class GenericButton
{
    /**
     * @var Context
     */
    protected $context;
    /**
     * @var PostRepositoryInterface
     */
    protected $postRepository;

    /**
     * GenericButton constructor.
     * @param Context $context
     * @param PostRepositoryInterface $postRepository
     */
    public function __construct(
        Context $context,
        PostRepositoryInterface $postRepository
    ) {

        $this->context = $context;
        $this->postRepository = $postRepository;
    }

    /**
     * Return post ID
     *
     * @return int|null
     */
    public function getPostId()
    {
        try {
            return $this->postRepository->getById(
                $this->context->getRequest()->getParam('post_id')
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