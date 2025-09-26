<?php

namespace NYX\Blog\Plugin;

use NYX\Blog\Api\Data\PostExtensionFactory;
use NYX\Blog\Api\Data\PostInterface;
use NYX\Blog\Api\Data\PostSearchResultInterface;
use NYX\Blog\Api\PostRepositoryInterface;
use NYX\Blog\Model\CommentRepository;
use NYX\Blog\Logger\Logger;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;
/**
 * Class PostRepositoryPlugin
 */
class PostRepository
{
    /**
     * Post comments field name
     */
    const FIELD_NAME = 'comments';

    private \NYX\Blog\Logger\Logger $_logger;

    /**
     * PostRepositoryPlugin constructor
     *
     * @param PostExtensionFactory $extensionFactory
     */
    public function __construct(
        Logger $logger,
        PostExtensionFactory $extensionFactory,
        CommentRepository $commentRepository,   
        FilterBuilder $filterBuilder,
        SearchCriteriaBuilder $searchCriteriaBuilder
    )
    {
        $this->_logger = $logger;
        $this->extensionFactory = $extensionFactory;
        $this->commentRepository = $commentRepository;
        $this->filterBuilder = $filterBuilder;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    private function aprovisinatePost( PostInterface $post)
    { 
        $extensionAttributes = $post->getExtensionAttributes();
        $extensionAttributes = $extensionAttributes ? $extensionAttributes : $this->extensionFactory->create();
       
        $filter = $this->filterBuilder
            ->setField('post_id')
            ->setValue($post->getId())
            ->setConditionType('eq')
            ->create();

        $searchCriteria = $this->searchCriteriaBuilder->addFilters([$filter])->create();

        $comments = $this->commentRepository->getList($searchCriteria)->getItems();
        $extensionAttributes->setComments($comments);
        $post->setExtensionAttributes($extensionAttributes);

        return $post;
    }

    /**
     * Add "comments" extension attribute to post data object to make it accessible in API data of post record
     *
     * @return PostInterface
     */
    public function afterGetById(PostRepositoryInterface $subject, PostInterface $post)
    {     
        return $this->aprovisinatePost($post);
    }

    /**
     * Add "comments" extension attribute to post data object to make it accessible in API data of all post list
     *
     * @return PostSearchResultInterface
     */
    public function afterGetList(PostRepositoryInterface $subject, PostSearchResultInterface $searchResult)
    {
        $posts = $searchResult->getItems();

        foreach ($posts as &$post) {
            try{
                $post = $this->aprovisinatePost($post);
            }catch(\Exception $e){
                $this->_logger->info("post ".$post->getId()." ".$e->getTraceAsString());
            }
        }

        return $searchResult;
    }
}