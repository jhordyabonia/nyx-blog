<?php
namespace NYX\Blog\Api\Data;
use Magento\Framework\Api\SearchResultsInterface;

interface CommentSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get comments list.
     *
     * @return CommentInterface[]
     */
    public function getItems();

    /**
     * Set comments list.
     *
     * @param CommentInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
