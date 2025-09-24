<?php

namespace NYX\Blog\Model\ResourceModel\Post;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use NYX\Blog\Model\ResourceModel\Post as PostResource;
use NYX\Blog\Model\Post as Post;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'post_id';

    protected function _construct()
    {
        $this->_init(Post::class, PostResource::class);
    }
}