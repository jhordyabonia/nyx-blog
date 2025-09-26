<?php

namespace NYX\Blog\Controller\Adminhtml\Comment;

use NYX\Blog\Controller\Adminhtml\AbstractComment;

class Edit extends AbstractComment
{
    /*protected function _initComment()
    {
        $comment = $this->commentFactory->create();
        $commentId = $this->getRequest()->getParam('comment_id', null);
        if ($commentId) {
            $comment->load($commentId,'comment_id');
            if (empty($comment->getData())) {
                return false;
            }
        }

        $this->coreRegistry->register('comment', $comment);
        return $comment;
    }*/

    public function execute()
    {
        $comment = $this->_initComment();

        if (!$comment) {
            $this->messageManager->addError(__('Please specify a correct comment.'));
            $this->_redirect('blog/comment/index');
            return;
        }
        $this->_initAction();
        $this->_view->getPage()->getConfig()->getTitle()->prepend(
            $comment->getCommentId() ? __('Comment #%1', $comment->getCommentId()) : __('New Comment')
        );

        $this->_view->renderLayout();
    }
}
