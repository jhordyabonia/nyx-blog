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
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Request\InvalidRequestException;

class Get extends \Magento\Framework\App\Action\Action implements CsrfAwareActionInterface
{
    protected $resultPageFactory;   
    public function __construct(        
        \NYX\Blog\Model\PostFactory $postFactory,
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $jsonResultFactory
    ) {
        $this->postFactory = $postFactory;
        $this->jsonResultFactory = $jsonResultFactory;
        parent::__construct($context);
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
