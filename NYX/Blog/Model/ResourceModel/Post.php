<?php

namespace NYX\Blog\Model\ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Post extends AbstractDb
{

    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('nyx_blog_post','post_id');
    }
}