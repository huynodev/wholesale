<?php

namespace Dev\Wholesale\Controller\Customer;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Exception\LocalizedException;

/**
 * Save Add Wholesale Contact Controller
 *
 * @author huynq8 ( huynq8@smartosc.com )
 */
class Save extends Action implements HttpPostActionInterface
{
    /**
     * @var \Dev\Wholesale\Model\WholesaleFactory
     */
    protected $wholesaleFactory;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Dev\Wholesale\Model\WholesaleFactory
     * @param \Magento\Framework\Controller\ResultFactory $resultFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context       $context,
        \Dev\Wholesale\Model\WholesaleFactory       $wholesaleFactory,
        \Magento\Framework\Controller\ResultFactory $resultFactory,
    )
    {
        parent::__construct($context);
        $this->wholesaleFactory = $wholesaleFactory;
        $this->resultFactory = $resultFactory;
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            if (empty($data['product_id']) || empty($data['customer_id'])) {
                return $resultRedirect->setPath('wholesale/customer');
            }
            $model = $this->wholesaleFactory->create();
            $data['created_at'] = strtotime(date('Y-m-d H:i:s'));
            $model->setData($data);
            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the wholesale contact.'));
                return $resultRedirect->setPath('wholesale/customer');
            } catch (LocalizedException $e) {
                $this->messageManager->addExceptionMessage($e->getPrevious() ?: $e);
            } catch (\Throwable $e) {
                $this->messageManager->addErrorMessage(__('Something went wrong while saving the banner.'));
            }
            return $resultRedirect->setPath('wholesale/customer');
        }
        return $resultRedirect->setPath('wholesale/customer');
    }
}
