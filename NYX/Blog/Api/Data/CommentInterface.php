<?php

namespace NYX\Blog\Api\Data;

interface CommentInterface
{
    const COMMENT_ID = 'comment_id';
    const POST_ID = 'post_id';
    const AUTHOR = 'author';
    const EMAIL = 'email';
    const CONTENT = 'content';
    const IS_APPROVED = 'is_approved';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    /** @return int */
    public function getCommentId();

    /** @return int */
    public function getPostId();

    /** @return string */
    public function getAuthor();

    /** @return string */
    public function getEmail();

    /** @return string */
    public function getContent();

    /** @return int|string */
    public function isApproved();

    /** @return string */
    public function getCreatedAt();

    /** @return string */
    public function getUpdatedAt();

    /** @param int $commentId
     * @return $this
     */
    public function setCommentId($commentId);

    /** @param int $postId
     * @return $this
     */
    public function setPostId($postId);

    /** @param string $author
     * @return $this
     */
    public function setAuthor($author);

    /** @param string $email
     * @return $this
     */
    public function setEmail($email);

    /** @param string $content
     * @return $this
     */
    public function setContent($content);

    /** @param int $isApproved
     * @return $this
     */
    public function setApproved($isApproved);

    /** @param string $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt);

    /** @param string $updatedAt
     * @return $this
     */
    public function setUpdatedAt($updatedAt);
}
