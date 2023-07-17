<?php

namespace Dev\Wholesale\Block\Customer\Wholesale;

use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;

/**
 * List Wholesale Contact View Block
 *
 * @author huynq8 ( huynq8@smartosc.com )
 */
class ListProduct extends \Magento\Customer\Block\Account\Dashboard
{
    /**
     * @var \Dev\Wholesale\Model\ResourceModel\Wholesale\Collection
     */
    protected $_collection;

    /**
     * @var \Dev\Wholesale\Model\ResourceModel\Wholesale\CollectionFactory
     */
    protected $_collectionFactory;

    /**
     * @var \Magento\Customer\Helper\Session\CurrentCustomer
     */
    protected $currentCustomer;

    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Newsletter\Model\SubscriberFactory $subscriberFactory
     * @param CustomerRepositoryInterface $customerRepository
     * @param AccountManagementInterface $customerAccountManagement
     * @param \Dev\Wholesale\Model\ResourceModel\Wholesale\CollectionFactory $collectionFactory
     * @param \Magento\Customer\Helper\Session\CurrentCustomer $currentCustomer
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context               $context,
        \Magento\Customer\Model\Session                                $customerSession,
        \Magento\Newsletter\Model\SubscriberFactory                    $subscriberFactory,
        CustomerRepositoryInterface                                    $customerRepository,
        AccountManagementInterface                                     $customerAccountManagement,
        \Dev\Wholesale\Model\ResourceModel\Wholesale\CollectionFactory $collectionFactory,
        \Magento\Catalog\Api\ProductRepositoryInterface                $productRepository,
        \Magento\Customer\Helper\Session\CurrentCustomer               $currentCustomer,
        array                                                          $data = [],
    )
    {
        $this->_collectionFactory = $collectionFactory;
        parent::__construct(
            $context,
            $customerSession,
            $subscriberFactory,
            $customerRepository,
            $customerAccountManagement,
            $data
        );
        $this->productRepository = $productRepository;
        $this->currentCustomer = $currentCustomer;
    }

    /**
     * Get Html Code For Toolbar
     *
     * @return string
     */
    public function getToolbarHtml()
    {
        return $this->getChildHtml('toolbar');
    }

    /**
     * Initializes Toolbar
     *
     * @return \Magento\Framework\View\Element\AbstractBlock
     */
    protected function _prepareLayout()
    {
        if ($this->getWholesales()) {
            $toolbar = $this->getLayout()->createBlock(
                \Magento\Theme\Block\Html\Pager::class,
                'customer_wholesale_list.toolbar'
            )->setCollection(
                $this->getWholesales()
            );

            $this->setChild('toolbar', $toolbar);
        }
        return parent::_prepareLayout();
    }

    /**
     * Get Wholesales
     *
     * @return bool|\Dev\Wholesale\Model\ResourceModel\Wholesale\Collection
     */
    public function getWholesales()
    {
        if (!($customerId = $this->currentCustomer->getCustomerId())) {
            return false;
        }
        if (!$this->_collection) {
            $this->_collection = $this->_collectionFactory->create();
            $this->_collection
                ->addFieldToFilter('customer_id', $customerId);
        }
        return $this->_collection;
    }

    /**
     * Get Wholesale URL
     *
     * @param \Dev\Wholesale\Model\Wholesale $wholesale
     * @return string
     */
    public function getWholesaleUrl($wholesale)
    {
        return $this->getUrl('wholesale/customer/view', ['id' => $wholesale->getWholesaleId()]);
    }

    /**
     * @param $wholesale
     * @return \Magento\Catalog\Api\Data\ProductInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */

    public function getProductData($wholesale)
    {
        return $this->productRepository->getById($wholesale->getProductId());
    }
}
