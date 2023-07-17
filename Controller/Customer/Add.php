<?php
namespace Dev\Wholesale\Controller\Customer;

use Dev\Wholesale\Controller\Customer as CustomerController;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;

/**
 * Add Wholesale Contact Controller
 *
 * @author huynq8 ( huynq8@smartosc.com )
 */
class Add extends CustomerController
{
    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Catalog\Model\ProductFactory $productFactory ,
     */
    public function __construct(
        Context                               $context,
        Session                               $customerSession,
        \Magento\Catalog\Model\ProductFactory $productFactory,

    )
    {
        $this->productFactory = $productFactory;
        parent::__construct($context, $customerSession);
    }

    /**
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $productId = $this->getRequest()->getParam('product_id');
        $product = $this->productFactory->create()->load($productId);
        if (!$product->getId() || !$this->customerSession->getCustomerId()) {
            /** @var \Magento\Framework\Controller\Result\Forward $resultForward */
            $resultForward = $this->resultFactory->create(ResultFactory::TYPE_FORWARD);
            $resultForward->forward('noroute');
            return $resultForward;
        }
        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        if ($navigationBlock = $resultPage->getLayout()->getBlock('customer_account_navigation')) {
            $navigationBlock->setActive('wholesale/customer');
        }
        $resultPage->getConfig()->getTitle()->set(__('Wholesale Contact Form'));
        return $resultPage;
    }
}
