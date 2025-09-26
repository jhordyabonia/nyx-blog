<?php

namespace NYX\Blog\Model\Post;

use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use NYX\Blog\Model\ResourceModel\Post\CollectionFactory;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var \NYX\Blog\Model\ResourceModel\Block\Collection
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
        CollectionFactory $postCollectionFactory,
        DataPersistorInterface $dataPersistor,
        StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = []
    )
    {
        $this->storeManager = $storeManager;
        $this->dataPersistor = $dataPersistor;
        $this->collection = $postCollectionFactory->create();
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
        /** @var \NYX\Blog\Model\Post $post */
        foreach ($items as $post) {
            $this->loadedData[$post->getId()] = $post->getData();
            if ($post->getPostFile()) {
                $m['post_file'][0]['name'] = $post->getPostFile();
                $m['post_file'][0]['url'] = $this->getMediaUrl().$post->getPostFile();
                $fullData = $this->loadedData;

                $this->loadedData[$post->getId()] = array_merge($fullData[$post->getId()], $m);
            }
        }

        $data = $this->dataPersistor->get('post');
        if (!empty($data)) {
            $post = $this->collection->getNewEmptyItem();
            $post->setData($data);
            $this->loadedData[$post->getId()] = $post->getData();
            $this->dataPersistor->clear('post');
        }

        return $this->loadedData;
    }

    public function getMediaUrl()
    {
        $mediaUrl = $this->storeManager->getStore()
            ->getBaseUrl(UrlInterface::URL_TYPE_MEDIA).'post/files/';
        return $mediaUrl;
    }
}