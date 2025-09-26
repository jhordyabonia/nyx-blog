<?php

namespace NYX\Blog\Controller\Adminhtml\Comment;

use NYX\Blog\Controller\Adminhtml\AbstractComment;

class Save extends AbstractComment
{
    public function execute()
    {
        $comment = $this->_initComment();
        if (!$comment) {
            $this->_redirect('blog/comment/index');
            return;
        }

        $data = $this->getRequest()->getPostValue();

        if (empty($data['comment_id'])) {
            $data['comment_id'] = null;
        }
        
        $comment->setData($data);

        try {
            $comment->save();
            $this->messageManager->addSuccess(__('The comment has been saved.'));
            if ($this->getRequest()->getParam('back', false)) {
                $this->_redirect(
                    'blog/comment/*/edit',
                    ['comment_id' => $comment->getId(), '_current' => true]
                );
            } else {
                $this->_redirect('blog/comment/index');
            }
            return;
        } catch (\Exception $exception) {
            $this->messageManager->addError($exception->getMessage());
            $this->logger->critical($exception);
            $this->_redirect('blog/comment/*/edit', ['_current' => true]);
            return;
        }
        $this->_redirect('blog/comment/*/');
        return;
    }
}
