<?php

namespace NYX\Blog\Controller\Adminhtml\Post;

use Magento\Framework\App\ResponseInterface;
use NYX\Blog\Controller\Adminhtml\AbstractPost;

class Save extends AbstractPost
{

    public function execute()
    {
        $post = $this->_initPost();

        if (!$post) {
            $this->_redirect('blog/post/index');
            return;
        }

        $data = $this->getRequest()->getPostValue();

        if (empty($data['post_id'])) {
            $data['post_id'] = null;
        }
        
        if (isset($data['post_file'][0]['name'])) {
            $data['post_file'] = $data['post_file'][0]['name'];
        } else {
            $data['post_file'] = null;
        }

        $post->setData($data);

        try {
            $post->save();
            $this->messageManager->addSuccess(__('The post has been saved.'));
            if ($this->getRequest()->getParam('back', false)) {
                $this->_redirect(
                    'blog/post/*/edit',
                    ['post_id' => $post->getId(), '_current' => true]
                );
            } else {
                $this->_redirect('blog/post/index');
            }
            return;
        } catch (\Exception $exception) {
            $this->messageManager->addError($exception->getMessage());
            $this->logger->critical($exception);
            $this->_redirect('blog/post/*/edit', ['_current' => true]);
            return;
        }
        $this->_redirect('bloc/post/*/');
        return;
    }
}