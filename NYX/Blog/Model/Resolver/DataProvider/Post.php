<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace NYX\Blog\Model\Resolver\DataProvider;

class Post
{

    private $postRepository;

    /**
     * @param \NYX\Blog\Api\PostRepositoryInterface $postRepository
     */
    public function __construct(
        \NYX\Blog\Api\PostRepositoryInterface $postRepository
    ) {
        $this->postRepository = $postRepository;
    }

    public function getPost()
    {
        return 'proviced data';
    }
}