<?php

namespace Dev\Wholesale\Block\Customer\Wholesale;

/**
 * Add Wholesale Contact Form Block
 *
 * @author huynq8 ( huynq8@smartosc.com )
 */
class Add extends \Magento\Framework\View\Element\Template
{
    /**
     * Wholesale Contact collection
     *
     * @var \Dev\Wholesale\Model\ResourceModel\Wholesale\Collection
     */
    protected $_collection;

    /**
     * @var \Magento\Customer\Helper\Session\CurrentCustomer
     */
    protected $currentCustomer;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Customer\Helper\Session\CurrentCustomer $currentCustomer
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     * @param \Dev\Wholesale\Model\ResourceModel\Wholesale\CollectionFactory $collectionFactory
     * @param \Magento\Catalog\Model\ProductFactory $productFactory
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context               $context,
        \Magento\Customer\Helper\Session\CurrentCustomer               $currentCustomer,
        \Magento\Catalog\Api\ProductRepositoryInterface                $productRepository,
        \Dev\Wholesale\Model\ResourceModel\Wholesale\CollectionFactory $collectionFactory,
        \Magento\Catalog\Model\ProductFactory                          $productFactory,
    )
    {
        parent::__construct(
            $context
        );
        $this->currentCustomer = $currentCustomer;
        $this->productRepository = $productRepository;
        $this->_collectionFactory = $collectionFactory;
        $this->productFactory = $productFactory;
        $this->setProductId($this->getRequest()->getParam('product_id', false));
    }

    /**
     * Form Action Url
     *
     * @return string
     */
    public function getFormAction()
    {
        return $this->getUrl('wholesale/customer/save');
    }

    /**
     * Get Current Customer
     *
     * @return \Magento\Customer\Api\Data\CustomerInterface
     */
    public function getCustomer()
    {
        return $this->currentCustomer->getCustomer();
    }

    /**
     * Get Fullname Current Customer
     *
     * @param $customer
     * @return string
     */
    public function getFullNameCustomer($customer)
    {
        $fullName = $customer->getFirstname() . ' ' . $customer->getLastname();
        return $fullName;
    }

    /**
     * Get Product Data
     *
     * @return \Magento\Catalog\Api\Data\ProductInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getProductData()
    {
        return $this->productRepository->getById($this->getProductId());
    }

    /**
     * Get Wholesale Contact Data
     *
     * @return \Dev\Wholesale\Model\ResourceModel\Wholesale\Collection|false
     */
    public function getWholesales()
    {
        if (!($customerId = $this->currentCustomer->getCustomerId())) {
            return false;
        }
        if (!$this->_collection) {
            $this->_collection = $this->_collectionFactory->create();
            $this->_collection
                ->addFieldToFilter('customer_id', $customerId)
                ->addFieldToFilter('product_id', $this->getProductId());
        }
        return $this->_collection;
    }


}
