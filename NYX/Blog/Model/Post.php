<?php

namespace NYX\Blog\Model;

use NYX\Blog\Api\Data\PostInterface;
use Magento\Framework\Model\AbstractExtensibleModel;
use Magento\Framework\Exception\LocalizedException;
use NYX\Blog\Model\ResourceModel\Post as PostResource;

class Post extends AbstractExtensibleModel implements PostInterface
{

    protected function _construct()
    {
        $this->_init(PostResource::class);
    }

    /**
     * @return string
     */
    public function getPostId()
    {
        return $this->getData(self::POST_ID);
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->getData(self::POST_EMAIL);
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->getData(self::POST_TITLE);
    }

    /**
     * @return string
     */
    public function getFile()
    {
        return $this->getData(self::POST_FILE);
    }

    /**
     * @return string
     */
    public function getDetails()
    {
        return $this->getData(self::POST_DETAILS);
    }
    /**
     * @return string
     */
    public function isActive()
    {
        $out = [__('Inactive'),__('Active')];
        return $out[$this->getData(self::POST_IS_ACTIVE)];
        #return $this->getData(self::POST_IS_ACTIVE)? 'Active' : 'Inactive';
    }
    
    /**
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->getData(self::UPDATED_AT);
    }

    /**
     * @param string $post_id
     * @return $this
     */
    public function setPostId(string $post_id)
    {
        return $this->setData(self::POST_ID, $post_id);
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title)
    {
        return $this->setData(self::POST_TITLE, $customer_id);
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email)
    {
        return $this->setData(self::POST_EMAIL, $email);
    }
    /**
     * @param string $details
     * @return $this
     */
    public function setDetails(string $details)
    {
        return $this->setData(self::POST_DETAILS, $details);
    }

    /**
     * @param string $file
     * @return $this
     */
    public function setFile(string $file)
    {
        return $this->setData(self::POST_FILE, $post_type);
    }
   
    /**
     * @param string $is_active
     * @return $this
     */
    public function setActive(string $is_active)
    {
        return $this->setData(self::POST_IS_ACTIVE, $is_active);
    }

    /**
     * @param string $created_at
     * @return $this
     */
    public function setCreatedAt(string $created_at)
    {
        return $this->setData(self::CREATED_AT, $created_at);
    }

    /**
     * @param string $updated_at
     * @return $this
     */
    public function setUpdatedAt(string $updated_at)
    {
        return $this->setData(self::UPDATED_AT, $updated_at);
    }
}