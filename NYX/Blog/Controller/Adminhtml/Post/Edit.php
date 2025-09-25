<?php

namespace NYX\Blog\Controller\Adminhtml\Post;

use Magento\Framework\App\ResponseInterface;
use NYX\Blog\Controller\Adminhtml\AbstractPost;

class Edit extends AbstractPost
{

    /**
     * Execute action based on request and return result
     *
     * Note: Request will be added as operation argument in future
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        /** @var \NYX\Blog\Model\Post $post */
        $post = $this->_initPost();
        if(!$post) {
            $this->messageManager->addError(__('Please specify a correct post.'));
            $this->_redirect('blog/post/index'); 
            return;
        }
        $this->_initAction();
        $this->_view->getPage()->getConfig()->getTitle()->prepend(
            $post->getPostId() ? $post->getTitle() : __('New Post')
        );
        $this->_view->renderLayout();
    }
}