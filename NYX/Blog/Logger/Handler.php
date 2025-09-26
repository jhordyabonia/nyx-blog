<?php

namespace NYX\Blog\Logger;

use Monolog\Logger;

class Handler extends \Magento\Framework\Logger\Handler\Base
{
    /**
     * Logging level
     * @var int
     */
    protected $loggerType = Logger::INFO | Logger::DEBUG;

    /**
     * File name
     * @var string
     */
    protected $fileName = '/var/log/nyx_blog.log';
}