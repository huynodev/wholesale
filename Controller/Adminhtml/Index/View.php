<?php

namespace Dev\Wholesale\Controller\Adminhtml\Index;

class View extends \Magento\Backend\App\Action
{
    /**
     * @var PageFactory|\Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var RequestInterface|\Magento\Framework\App\RequestInterface
     */
    protected $request;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\App\RequestInterface $request
     */
    public function __construct(
        \Magento\Backend\App\Action\Context        $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\App\RequestInterface    $request
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->request = $request;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $this->_view->loadLayout();
        $resultPage->setActiveMenu('Dev_Wholesale::wholesale');
        $resultPage->getConfig()->getTitle()->prepend(__('Wholesale Contact'));
        return $resultPage;
    }
}
