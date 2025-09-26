<?php
declare(strict_types=1);

/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace NYX\Blog\Controller\Post;


use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\App\CsrfAwareActionInterface;
use Magento\Framework\App\Request\InvalidRequestException;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\App\RequestInterface;
use NYX\Blog\Model\PostFactory;

class Get implements HttpGetActionInterface, CsrfAwareActionInterface
{
    public function __construct(
        private PostFactory $postFactory,
        private JsonFactory $jsonResultFactory,
        private RequestInterface $request
    ) {
    }

    /**
     * getCollection function
     * List active Post
     *
     * @return Collection
     */
    public function getCollection()
    {        
        $postCollection = $this->postFactory->create()->getCollection();
        $postCollection->addFieldToSelect('*')
                        ->addFieldToFilter('post_is_active',1)
                        ->setOrder('post_id','desc');          
        
        return $postCollection;
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
