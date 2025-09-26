<?php

namespace NYX\Blog\Controller\Adminhtml;

use Magento\Backend\App\Action;

abstract class AbstractComment extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry;
    /**
     * @var \NYX\Blog\Model\CommentFactory
     */
    protected $commentFactory;
    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \NYX\Blog\Model\CommentFactory $commentFactory,
        \Psr\Log\LoggerInterface $logger
    )
    {
        parent::__construct($context);
        $this->coreRegistry = $coreRegistry;
        $this->commentFactory = $commentFactory;
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
            __('Comment'),
            __('Comment')
        );
        return $this;
    }

    /**
     * Comment initialization
     *
     * @return \NYX\Blog\Model\Comment|boolean
     */
    protected function _initComment()
    {
        /** @var \NYX\Blog\Model\Comment $comment */
        $comment = $this->commentFactory->create();

        $commentId = $this->getRequest()->getParam('comment_id', null);
        if($commentId) {
            $comment->load($commentId,'comment_id');
            if (empty($comment->getData())) {
                return false;
            }
        }
        $this->coreRegistry->register('comment', $comment);
        return $comment;
    }


    public function _isAllowed()
    {
        return $this->_authorization->isAllowed('NYX_Blog::save');
    }
}
