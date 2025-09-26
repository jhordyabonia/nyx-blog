<?php

namespace NYX\Blog\Model\Comment;

use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use NYX\Blog\Model\ResourceModel\Comment\CollectionFactory;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var \NYX\Blog\Model\ResourceModel\Comment\Collection
     */
    protected $collection;

    /**
     * @var \Magento\Framework\App\Request\DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData;


    public function __construct(
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        CollectionFactory $commentCollectionFactory,
        DataPersistorInterface $dataPersistor,
        StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = []
    )
    {
        $this->storeManager = $storeManager;
        $this->dataPersistor = $dataPersistor;
        $this->collection = $commentCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        /** @var \NYX\Blog\Model\Comment $comment */
        foreach ($items as $comment) {
            $this->loadedData[$comment->getId()] = $comment->getData();
            if ($comment->getCommentFile()) {
                $m['comment_file'][0]['name'] = $comment->getCommentFile();
                $m['comment_file'][0]['url'] = $this->getMediaUrl().$comment->getCommentFile();
                $fullData = $this->loadedData;

                $this->loadedData[$comment->getId()] = array_merge($fullData[$comment->getId()], $m);
            }
        }

        $data = $this->dataPersistor->get('comment');
        if (!empty($data)) {
            $comment = $this->collection->getNewEmptyItem();
            $comment->setData($data);
            $this->loadedData[$comment->getId()] = $comment->getData();
            $this->dataPersistor->clear('comment');
        }

        return $this->loadedData;
    }

    public function getMediaUrl()
    {
        $mediaUrl = $this->storeManager->getStore()
            ->getBaseUrl(UrlInterface::URL_TYPE_MEDIA).'comment/files/';
        return $mediaUrl;
    }
}