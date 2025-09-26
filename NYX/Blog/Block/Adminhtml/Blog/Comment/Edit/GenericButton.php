<?php

namespace NYX\Blog\Block\Adminhtml\Blog\Comment\Edit;

use Magento\Backend\Block\Widget\Context;
use NYX\Blog\Api\CommentRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class GenericButton
{
    protected $context;
    protected $commentRepository;

    public function __construct(
        Context $context,
        CommentRepositoryInterface $commentRepository
    )
    {
        $this->context = $context;
        $this->commentRepository = $commentRepository;
    }

    public function getCommentId()
    {
        try {
            return $this->commentRepository->getById(
                $this->context->getRequest()->getParam('comment_id')
            )->getId();
        } catch (NoSuchEntityException $e) {
        }
        return null;
    }

    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
