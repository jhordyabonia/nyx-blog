<?php

namespace NYX\Blog\Controller\Adminhtml\Comment;

class NewAction extends \Magento\Backend\App\Action
{
    public function execute()
    {
        $this->_forward('edit');
    }
}
