<?php

namespace NYX\Blog\Model;

use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use NYX\Blog\Api\PostRepositoryInterface;
use NYX\Blog\Model\ResourceModel\Post;
use NYX\Blog\Model\PostFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use NYX\Blog\Api\Data\PostInterface;
use NYX\Blog\Api\Data\PostSearchResultsInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Api\SearchResultsInterface;
use NYX\Blog\Api\Data\PostInterfaceFactory;
use NYX\Blog\Api\Data\PostSearchResultsInterfaceFactory;
use NYX\Blog\Model\ResourceModel\Post as PostResource;
use NYX\Blog\Model\ResourceModel\Post\CollectionFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\App\ObjectManager;
/**
 * Class PostRepository
 * @package NYX\Blog\Model
 */
class PostRepository implements PostRepositoryInterface
{
    /**
     * @var ResourceModel\Post
     */
    private $resource;
    /**
     * @var PostFactory
     */
    private $postFactory;
    /**
     * @var \NYX\Blog\Api\Data\PostInterfaceFactory
     */
    private $dataPostFactory;
    /**
     * @var ResourceModel\Post\CollectionFactory
     */
    private $postCollectionFactory;
    /**
     * @var \NYX\Blog\Api\Data\PostSearchResultsInterfaceFactory
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
        Post $resource,
        PostFactory $postFactory,
        PostInterfaceFactory $dataPostFactory,
        Post\CollectionFactory $postCollectionFactory,
        PostSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        CollectionProcessorInterface $collectionProcessor = null
    )
    {
        $this->resource = $resource;
        $this->postFactory = $postFactory;
        $this->dataPostFactory = $dataPostFactory;
        $this->postCollectionFactory = $postCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->collectionProcessor = $collectionProcessor ?: $this->getCollectionProcessor();
    }

    /**
     * Save post.
     *
     * @param PostInterface $post
     * @return PostInterface
     * @throws LocalizedException
     */
    public function save(PostInterface $post)
    {
        try {
            $this->resource->save($post);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save the post: %1', $exception->getMessage()),
                $exception
            );
        }
        return $post;
    }

    /**
     * Retrieve post.
     *
     * @param int $postId
     * @return PostInterface
     * @throws LocalizedException
     */
    public function getById($postId)
    {
        $post = $this->postFactory->create();
        $post->load($postId);
        if (!$post->getId()) {
            throw new NoSuchEntityException(__('Post with id "%1" does not exist.', $postId));
        }
        return $post;
    }

    /**
     * Retrieve posts matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return PostSearchResultsInterface
     * @throws LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        /** @var \NYX\Blog\Model\ResourceModel\Block\Collection $collection */
        $collection = $this->postCollectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        /** @var PostSearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * Delete post.
     *
     * @param PostInterface $post
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete(PostInterface $post)
    {
        try {
            $this->resource->delete($post);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete post: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * Delete post by ID.
     *
     * @param int $postId
     * @return bool true on success
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function deleteById($postId)
    {
        return $this->delete($this->getById($postId));
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