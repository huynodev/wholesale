<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Dev\Wholesale\Controller\Customer;

use Magento\Framework\Controller\ResultFactory;
use Magento\Review\Controller\Customer as CustomerController;

/**
 * Detail Wholesale Contact Controller
 *
 * @author huynq8 ( huynq8@smartosc.com )
 */
class View extends CustomerController
{
    /**
     * @var \Dev\Wholesale\Model\WholesaleFactory
     */
    protected $wholesaleFactory;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Dev\Wholesale\Model\WholesaleFactory $reviewFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Customer\Model\Session       $customerSession,
        \Dev\Wholesale\Model\WholesaleFactory $wholesaleFactory
    )
    {
        $this->wholesaleFactory = $wholesaleFactory;
        parent::__construct($context, $customerSession);
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $wholesale = $this->wholesaleFactory->create()->load($this->getRequest()->getParam('id'));
        if ($wholesale->getCustomerId() != $this->customerSession->getCustomerId()) {
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
        $resultPage->getConfig()->getTitle()->set(__('Wholesale Details'));
        return $resultPage;
    }
}
