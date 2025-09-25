<?php

namespace NYX\Blog\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use NYX\Blog\Api\Data\CommentInterface;
use NYX\Blog\Api\Data\CommentSearchResultsInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Api\SearchResultsInterface; 

/**
 * Comment repository interface.
 * @api
 */

interface CommentRepositoryInterface
{
    /**
     * Save comment.
     *
     * @param CommentInterface $comment
     * @return CommentInterface
     * @throws LocalizedException
     */
    public function save(CommentInterface $comment);

    /**
     * Retrieve comment.
     *
     * @param int $commentId
     * @return CommentInterface
     * @throws LocalizedException
     */
    public function getById($commentId);

    /**
     * Retrieve comments matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return CommentSearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete comment.
     *
     * @param CommentInterface $comment
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(CommentInterface $comment);

    /**
     * Delete comment by ID.
     *
     * @param int $commentId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById($commentId);
}
