<?php

namespace Dev\Wholesale\Block\Adminhtml\Wholesale;

use Magento\Framework\View\Element\Template;
use Magento\Framework\Pricing\PriceCurrencyInterface;

/**
 * Button Add Wholesale Contact Block
 *
 * @author huynq8 ( huynq8@smartosc.com )
 */
class Info extends \Magento\Framework\View\Element\Template
{

    /**
     * @param Template\Context $context
     * @param \Dev\Wholesale\Model\WholesaleFactory $wholesaleFactory
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     * @param PriceCurrencyInterface $priceCurrency
     * @param array $data
     */
    public function __construct(
        Template\Context                                $context,
        \Dev\Wholesale\Model\WholesaleFactory           $wholesaleFactory,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        PriceCurrencyInterface                          $priceCurrency,
        array                                           $data = [],

    )
    {
        $this->wholesaleFactory = $wholesaleFactory;
        $this->productRepository = $productRepository;
        $this->priceCurrency = $priceCurrency;
        $this->validator = $context->getValidator();
        $this->resolver = $context->getResolver();
        $this->_filesystem = $context->getFilesystem();
        $this->templateEnginePool = $context->getEnginePool();
        $this->_storeManager = $context->getStoreManager();
        $this->_appState = $context->getAppState();
        $this->templateContext = $this;
        $this->pageConfig = $context->getPageConfig();
        parent::__construct($context, $data);
    }

    /**
     * @return \Dev\Wholesale\Model\Wholesale
     */
    public function getWholesaleData()
    {
        $wholesaleId = $this->getRequest()->getParam('wholesale_id', false);
        return $this->wholesaleFactory->create()->load($wholesaleId);
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

    /**
     * @param $product
     * @return string
     */
    public function getPriceProduct($product)
    {
        return $this->priceCurrency->format($product->getPrice());
    }

    /**
     * @param $wholesale
     * @return string
     */
    public function getActionForm($wholesale)
    {
        return $this->getUrl('wholesale/view/mail/', ['wholesale_id' => $wholesale->getWholesaleId()]);
    }
}
