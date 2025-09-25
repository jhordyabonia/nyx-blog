<?php

namespace NYX\Blog\Block;

use Magento\Framework\View\Element\Template;
use NYX\Blog\Model\PostFactory;
/**
 * Class Post
 */ 

class Post extends Template
{    
    /**
    * @var \NYX\Blog\Model\PostFactory
    */
    protected $postFactory;
    
    /**
     * @param Template\Context $context
     * @param NYX\Blog\Model\PostFactory $postFactory
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        PostFactory $postFactory,
        array $data = [])
    {
        $this->postFactory = $postFactory;
        parent::__construct($context, $data);
    }
    
    /**     
     * @return array
     */
    public function getCollection()
    {        
        $postCollection = $this->postFactory->create()->getCollection();

        $postCollection->addFieldToSelect('*')
                        ->addFieldToFilter('post_is_active',1);          
        
        return $postCollection;
    }
}