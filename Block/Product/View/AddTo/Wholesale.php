<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Dev\Wholesale\Block\Product\View\AddTo;

use Magento\Catalog\Api\ProductRepositoryInterface;

/**
 * Button Add Wholesale Contact Block
 *
 * @author huynq8 ( huynq8@smartosc.com )
 */
class Wholesale extends \Magento\Catalog\Block\Product\View
{
    /**
     * Wholesale Contact Collection
     *
     * @var \Dev\Wholesale\Model\ResourceModel\Wholesale\Collection
     */
    protected $_collection;

    /**
     * @param \Magento\Catalog\Block\Product\Context $context
     * @param \Magento\Framework\Url\EncoderInterface $urlEncoder
     * @param \Magento\Framework\Json\EncoderInterface $jsonEncoder
     * @param \Magento\Framework\Stdlib\StringUtils $string
     * @param \Magento\Catalog\Helper\Product $productHelper
     * @param \Magento\Catalog\Model\ProductTypes\ConfigInterface $productTypeConfig
     * @param \Magento\Framework\Locale\FormatInterface $localeFormat
     * @param \Magento\Customer\Model\Session $customerSession
     * @param ProductRepositoryInterface $productRepository
     * @param \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency
     * @param \Magento\Review\Model\ResourceModel\Review\CollectionFactory $collectionFactory
     * @param \Magento\Customer\Helper\Session\CurrentCustomer $currentCustomer
     * @param \Dev\Wholesale\Model\ResourceModel\Wholesale\CollectionFactory $collectionFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Catalog\Block\Product\Context                         $context,
        \Magento\Framework\Url\EncoderInterface                        $urlEncoder,
        \Magento\Framework\Json\EncoderInterface                       $jsonEncoder,
        \Magento\Framework\Stdlib\StringUtils                          $string,
        \Magento\Catalog\Helper\Product                                $productHelper,
        \Magento\Catalog\Model\ProductTypes\ConfigInterface            $productTypeConfig,
        \Magento\Framework\Locale\FormatInterface                      $localeFormat,
        \Magento\Customer\Model\Session                                $customerSession,
        ProductRepositoryInterface                                     $productRepository,
        \Magento\Framework\Pricing\PriceCurrencyInterface              $priceCurrency,
        \Magento\Customer\Helper\Session\CurrentCustomer               $currentCustomer,
        \Dev\Wholesale\Model\ResourceModel\Wholesale\CollectionFactory $collectionFactory,
        array                                                          $data = []
    )
    {
        $this->currentCustomer = $currentCustomer;
        $this->_collectionFactory = $collectionFactory;
        parent::__construct(
            $context,
            $urlEncoder,
            $jsonEncoder,
            $string,
            $productHelper,
            $productTypeConfig,
            $localeFormat,
            $customerSession,
            $productRepository,
            $priceCurrency,
            $data
        );
    }

    /**
     * Get Product ID
     */
    public function getProductId()
    {
        $product = $this->getProduct();
        return $product->getId();
    }

    /**
     * Get Add Wholesale Contact Form URL
     */
    public function wholesaleUrl()
    {
        return $this->getUrl('wholesale/customer/add', ['product_id' => $this->getProductId()]);
    }

    /**
     * Check Customer Have Wholesale Contact
     */
    public function checkWholesales()
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
        if ($this->_collection && count($this->_collection)) {
            return false;
        }
        return true;
    }
}
