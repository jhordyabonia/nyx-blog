<?php
declare(strict_types=1);

/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace NYX\Blog\Controller\Comment;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\App\CsrfAwareActionInterface;
use Magento\Framework\App\Request\InvalidRequestException;
use NYX\Blog\Model\CommentFactory;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\App\RequestInterface;

class Get implements HttpGetActionInterface, CsrfAwareActionInterface
{
    public function __construct(
        private CommentFactory $commentFactory,
        private JsonFactory $jsonResultFactory,
        private RequestInterface $request
    ) {
    }

    /**
     * getCollection function
     * List active Comment
     *
     * @return Collection
     */
    public function getCollection()
    {        

        $postId = $this->request->getParam('post_id');
        $commentCollection = $this->commentFactory->create()->getCollection();
        $commentCollection->addFieldToSelect('*')
                        ->addFieldToFilter('post_id',$postId)
                        ->addFieldToFilter('is_approved',1)
                        ->setOrder('comment_id','desc');

        return $commentCollection;
    }
    /**
     * Show Blog page
     */
    public function execute(){
        $out = $this->getCollection()->getData();
        return $this->jsonResultFactory->create()->setData($out);        
    }

    public function createCsrfValidationException(RequestInterface $request): ? InvalidRequestException
    {
        return null;
    }

    public function validateForCsrf(RequestInterface $request): ?bool
    {
        return true;
    }
}
