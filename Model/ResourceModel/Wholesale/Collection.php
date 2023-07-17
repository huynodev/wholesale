<?php

namespace Dev\Wholesale\Model\ResourceModel\Wholesale;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            'Dev\Wholesale\Model\Wholesale',
            'Dev\Wholesale\Model\ResourceModel\Wholesale'
        );
    }
}
