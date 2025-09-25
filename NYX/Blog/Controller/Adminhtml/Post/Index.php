<?php

namespace NYX\Blog\Controller\Adminhtml\Post;

use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;

class Index extends \Magento\Backend\App\Action
{
    public function execute()
    {
        //ini_set('max_input_vars', 10000);
        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()->getTitle()->set(__('Post List'));
        return $resultPage;

    }/*
    public function _isAllowed(){
        return $this->_authorization->isAllowed('NYX_Blog::view');
    }*/
}
