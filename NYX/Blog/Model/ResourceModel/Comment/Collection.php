<?php

namespace NYX\Blog\Model\ResourceModel\Comment;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use NYX\Blog\Model\ResourceModel\Comment as CommentResource;
use NYX\Blog\Model\Comment as Comment;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'comment_id';

    protected function _construct()
    {
        $this->_init(Comment::class, CommentResource::class);
    }
}
