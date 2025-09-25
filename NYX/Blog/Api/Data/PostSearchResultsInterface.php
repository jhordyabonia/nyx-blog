<?php
namespace NYX\Blog\Api\Data;
use Magento\Framework\Api\SearchResultsInterface;
use NYX\Blog\Api\Data\PostInterface;

/**
 * Interface PostSearchResultsInterface
 * @package NYX\Blog\Api\Data
 */

interface PostSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get pages list.
     *
     * @return PostInterface[]
     */
    public function getItems();

    /**
     * Set pages list.
     *
     * @param PostInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}