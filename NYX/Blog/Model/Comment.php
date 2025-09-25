<?php

namespace NYX\Blog\Model;

use NYX\Blog\Api\Data\CommentInterface;
use Magento\Framework\Model\AbstractExtensibleModel;
use NYX\Blog\Model\ResourceModel\Comment as CommentResource;

class Comment extends AbstractExtensibleModel implements CommentInterface
{
    protected function _construct()
    {
        $this->_init(CommentResource::class);
    }

    public function getCommentId()
    {
        return $this->getData(self::COMMENT_ID);
    }

    public function getPostId()
    {
        return $this->getData(self::POST_ID);
    }

    public function getAuthor()
    {
        return $this->getData(self::AUTHOR);
    }

    public function getEmail()
    {
        return $this->getData(self::EMAIL);
    }

    public function getContent()
    {
        return $this->getData(self::CONTENT);
    }

    public function isApproved()
    {
        $out = [__('Pending'), __('Approved')];
        return $out[$this->getData(self::IS_APPROVED)];
    }

    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    public function getUpdatedAt()
    {
        return $this->getData(self::UPDATED_AT);
    }

    public function setCommentId($commentId)
    {
        return $this->setData(self::COMMENT_ID, $commentId);
    }

    public function setPostId($postId)
    {
        return $this->setData(self::POST_ID, $postId);
    }

    public function setAuthor($author)
    {
        return $this->setData(self::AUTHOR, $author);
    }

    public function setEmail($email)
    {
        return $this->setData(self::EMAIL, $email);
    }

    public function setContent($content)
    {
        return $this->setData(self::CONTENT, $content);
    }

    public function setApproved($isApproved)
    {
        return $this->setData(self::IS_APPROVED, $isApproved);
    }

    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    public function setUpdatedAt($updatedAt)
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }
}
