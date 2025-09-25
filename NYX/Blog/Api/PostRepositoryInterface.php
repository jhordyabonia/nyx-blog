<?php

namespace NYX\Blog\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use NYX\Blog\Api\Data\PostInterface;
use NYX\Blog\Api\Data\PostSearchResultsInterface;  
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Api\SearchResultsInterface; 

/**
 * Post repository interface. [CRUD]
 * @api
 */

interface PostRepositoryInterface
{
    /**
     * Save post.
     *
     * @param PostInterface $post
     * @return PostInterface
     * @throws LocalizedException
     */
    public function save(PostInterface $post);

    /**
     * Retrieve post.
     *
     * @param int $pageId
     * @return PostInterface
     * @throws LocalizedException
     */
    public function getById($postId);

    /**
     * Retrieve posts matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return PostSearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete post.
     *
     * @param PostInterface $post
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(PostInterface $post);

    /**
     * Delete post by ID.
     *
     * @param int $postId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById($postId);
}
