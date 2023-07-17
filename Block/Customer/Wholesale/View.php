<?php

namespace Dev\Wholesale\Block\Customer\Wholesale;

use Dev\Wholesale\Model\Wholesale;
use Magento\Catalog\Model\Product;

/**
 * Detail Wholesale Contact View Block
 *
 * @author huynq8 ( huynq8@smartosc.com )
 */
class View extends \Magento\Catalog\Block\Product\AbstractProduct
{

    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var \Dev\Wholesale\Model\WholesaleFactory
     */
    protected $_wholesaleFactory;

    /**
     * @var \Magento\Customer\Helper\Session\CurrentCustomer
     */
    protected $currentCustomer;

    /**
     * @param \Magento\Catalog\Block\Product\Context $context
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     * @param \Dev\Wholesale\Model\WholesaleFactory $wholesaleFactory
     * @param \Magento\Customer\Helper\Session\CurrentCustomer $currentCustomer
     * @param array $data
     */
    public function __construct(
        \Magento\Catalog\Block\Product\Context           $context,
        \Magento\Catalog\Api\ProductRepositoryInterface  $productRepository,
        \Dev\Wholesale\Model\WholesaleFactory            $wholesaleFactory,
        \Magento\Customer\Helper\Session\CurrentCustomer $currentCustomer,
        array                                            $data = []
    )
    {
        $this->productRepository = $productRepository;
        $this->_wholesaleFactory = $wholesaleFactory;
        $this->currentCustomer = $currentCustomer;
        parent::__construct(
            $context,
            $data
        );
    }

    /**
     * Initialize Wholesale Id
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setWholesaleId($this->getRequest()->getParam('id', false));
    }

    /**
     * Get Product Data
     *
     * @return \Magento\Catalog\Api\Data\ProductInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getProductData()
    {
        return $this->productRepository->getById($this->getWholesaleData()->getProductId());
    }

    /**
     * Get Wholesale Data
     *
     * @return Wholesale
     */
    public function getWholesaleData()
    {
        if ($this->getWholesaleId() && !$this->getWholesaleCachedData()) {
            $this->setWholesaleCachedData($this->_wholesaleFactory->create()->load($this->getWholesaleId()));
        }
        return $this->getWholesaleCachedData();
    }

    /**
     * Return Wholesale Customer URL
     *
     * @return string
     */
    public function getBackUrl()
    {
        return $this->getUrl('wholesale/customer');
    }

    /**
     * @inheritDoc
     */
    protected function _toHtml()
    {
        return $this->currentCustomer->getCustomerId() ? parent::_toHtml() : '';
    }
}
