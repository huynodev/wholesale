<?php

namespace Dev\Wholesale\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Wholesale extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('wholesale_contact', 'wholesale_id');
    }
}
