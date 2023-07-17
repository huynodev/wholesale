<?php

namespace Dev\Wholesale\Controller\Adminhtml\View;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Backend\App\Action;

class Detail extends \Magento\Backend\App\Action implements HttpGetActionInterface
{

    const ADMIN_RESOURCE = 'Dev_Wholesale::detail';

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Dev\Wholesale\Model\WholesaleFactory $wholesaleFactory
     */
    public function __construct(
        Action\Context                             $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Dev\Wholesale\Model\WholesaleFactory      $wholesaleFactory,
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->wholesaleFactory = $wholesaleFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\View\Result\Page
     */
    protected function _initAction()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Dev_Wholesale::wholesale');
        return $resultPage;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('wholesale_id');
        $model = $this->wholesaleFactory->create();

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This wholesale contact no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('wholesale/index/view');
            }
        }
        $resultPage = $this->_initAction();
        $resultPage->getConfig()->getTitle()
            ->prepend(__('Wholesale Details'));
        return $resultPage;
    }
}
