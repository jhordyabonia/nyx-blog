<?php

namespace NYX\Blog\Api\Data;

interface PostInterface
{
    const POST_ID = 'post_id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const POST_TITLE = 'post_title';
    const POST_DETAILS = 'post_details';
    const POST_FILE = 'post_file';
    const POST_EMAIL = 'post_email';
    const POST_IS_ACTIVE = 'is_active';

    /**
     * @return string
     */
    public function getEmail();

    /**
     * @return string
     */
    public function getPostId();

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @return string
     */
    public function getDetails();
    /**
     * @return string
     */
    public function isActive();
    /**
     * @return string
     */
    public function getFile();

    /**
     * @return string
     */
    public function getCreatedAt();

    /**
     * @return string
     */
    public function getUpdatedAt();

    /**
     * @param string $post_id
     * @return $this
     */
    public function setPostId(string $post_id);

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email);

    /**
     * @param string $post_name
     * @return $this
     */
    public function setTitle(string $title);

    /**
     * @param string $details
     * @return $this
     */
    public function setDetails(string $details);

    /**
     * @param string $file
     * @return $this
     */
    public function setFile(string $file);


    /**
     * @param string $is_active
     * @return $this
     */
    public function setActive(string $is_active);

    /**
     * @param string $created_at
     * @return $this
     */
    public function setCreatedAt(string $created_at);

    /**
     * @param string $updated_at
     * @return $this
     */
    public function setUpdatedAt(string $updated_at);
}
