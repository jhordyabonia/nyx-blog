<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace NYX\Blog\Model;

/**
 * Class Status
 */
class Status implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        return [
            ['label' => __('Active'), 'value' => 1],
            ['label' => __('Inactive'), 'value' => 0]
        ];
    }
}
