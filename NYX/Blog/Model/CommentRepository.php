<?php

namespace NYX\Blog\Model;

use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use NYX\Blog\Api\CommentRepositoryInterface;
use NYX\Blog\Model\ResourceModel\Comment;
use NYX\Blog\Model\CommentFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use NYX\Blog\Api\Data\CommentInterface;
use NYX\Blog\Api\Data\CommentSearchResultsInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Api\SearchResultsInterface;
use NYX\Blog\Api\Data\CommentInterfaceFactory;
use NYX\Blog\Api\Data\CommentSearchResultsInterfaceFactory;
use NYX\Blog\Model\ResourceModel\Comment as CommentResource;
use NYX\Blog\Model\ResourceModel\Comment\CollectionFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\App\ObjectManager;
/**
 * Class CommentRepository
 * @package NYX\Blog\Model
 */
class CommentRepository implements CommentRepositoryInterface
{
    /**
     * @var ResourceModel\Comment
     */
    private $resource;
    /**
     * @var CommentFactory
     */
    private $commentFactory;
    /**
     * @var \NYX\Blog\Api\Data\CommentInterfaceFactory
     */
    private $dataCommentFactory;
    /**
     * @var ResourceModel\Comment\CollectionFactory
     */
    private $commentCollectionFactory;
    /**
     * @var \NYX\Blog\Api\Data\CommentSearchResultsInterfaceFactory
     */
    private $searchResultsFactory;
    /**
     * @var \Magento\Framework\Api\DataObjectHelper
     */
    private $dataObjectHelper;
    /**
     * @var \Magento\Framework\Reflection\DataObjectProcessor
     */
    private $dataObjectProcessor;
    /**
     * @var \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface
     */
    private $collectionProcessor;

    public function __construct(
        Comment $resource,
        CommentFactory $commentFactory,
        CommentInterfaceFactory $dataCommentFactory,
        Comment\CollectionFactory $commentCollectionFactory,
        CommentSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        CollectionProcessorInterface $collectionProcessor = null
    )
    {
        $this->resource = $resource;
        $this->commentFactory = $commentFactory;
        $this->dataCommentFactory = $dataCommentFactory;
        $this->commentCollectionFactory = $commentCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->collectionProcessor = $collectionProcessor ?: $this->getCollectionProcessor();
    }

    /**
     * Save comment.
     *
     * @param CommentInterface $comment
     * @return CommentInterface
     * @throws LocalizedException
     */
    public function save(CommentInterface $comment)
    {
        try {
            $this->resource->save($comment);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save the comment: %1', $exception->getMessage()),
                $exception
            );
        }
        return $comment;
    }

    /**
     * Retrieve comment.
     *
     * @param int $commentId
     * @return CommentInterface
     * @throws LocalizedException
     */
    public function getById($commentId)
    {
        $comment = $this->commentFactory->create();
        $comment->load($commentId);
        if (!$comment->getId()) {
            throw new NoSuchEntityException(__('Comment with id "%1" does not exist.', $commentId));
        }
        return $comment;
    }

    /**
     * Retrieve comments matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return CommentSearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        /** @var \NYX\Blog\Model\ResourceModel\Block\Collection $collection */
        $collection = $this->commentCollectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        /** @var CommentSearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * Delete comment.
     *
     * @param CommentInterface $comment
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(CommentInterface $comment)
    {
        try {
            $this->resource->delete($comment);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete comment: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * Delete comment by ID.
     *
     * @param int $commentId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById($commentId)
    {
        return $this->delete($this->getById($commentId));
    }

    /**
     * Retrieve collection processor
     *
     * @deprecated 100.2.0
     * @return CollectionProcessorInterface
     */
    private function getCollectionProcessor()
    {
        if (!$this->collectionProcessor) {
            $this->collectionProcessor = ObjectManager::getInstance()->get(
                CollectionProcessorInterface::class
            );
        }
        return $this->collectionProcessor;
    }
}