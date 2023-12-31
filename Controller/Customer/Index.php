<?php
namespace Dev\Wholesale\Controller\Customer;

use Dev\Wholesale\Controller\Customer as CustomerController;
use Magento\Framework\Controller\ResultFactory;

/**
 * List Wholesale Contact Controller
 *
 * @author huynq8 ( huynq8@smartosc.com )
 */
class Index extends CustomerController
{
    /**
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        if ($navigationBlock = $resultPage->getLayout()->getBlock('customer_account_navigation')) {
            $navigationBlock->setActive('wholesale/customer');
        }
        if ($block = $resultPage->getLayout()->getBlock('wholesale_customer_list')) {
            $block->setRefererUrl($this->_redirect->getRefererUrl());
        }
        $resultPage->getConfig()->getTitle()->set(__('My Product Wholesale'));
        return $resultPage;
    }
}
