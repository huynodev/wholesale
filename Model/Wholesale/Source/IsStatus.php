<?php

namespace Dev\Wholesale\Model\Wholesale\Source;

use Magento\Framework\Data\OptionSourceInterface;

class IsStatus implements OptionSourceInterface
{
    /**
     * @var \Dev\Wholesale\Model\Wholesale
     */
    protected $wholesale;

    /**
     * @param \Dev\Wholesale\Model\Wholesale $wholesale
     */
    public function __construct(
        \Dev\Wholesale\Model\Wholesale $wholesale
    )
    {
        $this->wholesale = $wholesale;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $availableOptions = $this->wholesale->getAvailableStatuses();
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}
