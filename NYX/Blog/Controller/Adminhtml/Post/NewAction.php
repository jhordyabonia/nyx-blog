<?php

namespace NYX\Blog\Controller\Adminhtml\Post;

use Magento\Framework\App\ResponseInterface;
use Magento\Backend\App\Action;

class NewAction extends Action
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
        $this->_forward('edit');
    }
    public function _isAllowed(){
        return $this->_authorization->isAllowed('NYX_Blog::view');
    }
}