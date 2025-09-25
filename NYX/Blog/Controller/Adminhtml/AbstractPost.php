<?php

namespace NYX\Blog\Controller\Adminhtml;

use Magento\Backend\App\Action;

abstract class AbstractPost extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry;
    /**
     * @var \NYX\Blog\Model\PostFactory
     */
    protected $postFactory;
    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \NYX\Blog\Model\PostFactory $postFactory,
        \Psr\Log\LoggerInterface $logger
    )
    {
        parent::__construct($context);
        $this->coreRegistry = $coreRegistry;
        $this->postFactory = $postFactory;
        $this->logger = $logger;
    }

    protected function _initAction()
    {
        $this->_view->loadLayout();
        $this->_setActiveMenu(
            'Magento_Backend::content_elements'
        )->_addBreadcrumb(
            __('Content'),
            __('Content')
        )->_addBreadcrumb(
            __('Post'),
            __('Post')
        );
        return $this;
    }

    /**
     * Post initialization
     *
     * @return \NYX\Blog\Model\Post|boolean
     */
    protected function _initPost()
    {
        /** @var \NYX\Blog\Model\Post $post */
        $post = $this->postFactory->create();

        $postId = $this->getRequest()->getParam('post_id', null);
        if($postId) {
            $post->load($postId,'post_id');
            if (empty($post->getTitle())) {
                return false;
            }
        }
        $this->coreRegistry->register('post', $post);
        return $post;
    }


    public function _isAllowed()
    {
        return $this->_authorization->isAllowed('NYX_Blog::save');
    }
}
