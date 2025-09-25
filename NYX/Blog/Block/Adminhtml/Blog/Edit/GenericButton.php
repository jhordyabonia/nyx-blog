<?php
/**
 * User: david
 * Date: 9/28/18
 * Time: 4:23 PM
 */

namespace NYX\Blog\Block\Adminhtml\Blog\Edit;


class GenericButton
{
    /**
     * @var \Magento\Backend\Block\Widget\Context
     */
    protected $context;
    /**
     * @var \NYX\Blog\Api\PostRepositoryInterface
     */
    protected $postRepository;

    /**
     * GenericButton constructor.
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \NYX\Blog\Api\PostRepositoryInterface $postRepository
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \NYX\Blog\Api\PostRepositoryInterface $postRepository
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
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
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