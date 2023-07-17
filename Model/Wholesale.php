<?php

namespace Dev\Wholesale\Model;

use Magento\Framework\Model\AbstractModel;

class Wholesale extends AbstractModel
{
    const STATUS_UNSENT = 0;
    const STATUS_SENT = 1;

    protected function _construct()
    {
        $this->_init('Dev\Wholesale\Model\ResourceModel\Wholesale');
    }

    public function getAvailableStatuses()
    {
        return [self::STATUS_UNSENT => __('Unsent'), self::STATUS_SENT => __('Sent')];
    }
}
