<?php

namespace NYX\Blog\Model\ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Comment extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('nyx_blog_post_comment', 'comment_id');
    }
}
