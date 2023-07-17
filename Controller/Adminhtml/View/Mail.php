<?php

declare(strict_types=1);

namespace Dev\Wholesale\Controller\Adminhtml\View;

use Exception;
use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpPostActionInterface;

class Mail extends Action implements HttpPostActionInterface
{
    private $wholesaleFactory;
    private $transportBuilder;

    /**
     * @param Action\Context $context
     * @param \Dev\Wholesale\Model\WholesaleFactory $wholesaleFactory
     * @param \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     */
    public function __construct(
        Action\Context                                    $context,
        \Dev\Wholesale\Model\WholesaleFactory             $wholesaleFactory,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Catalog\Api\ProductRepositoryInterface   $productRepository
    )
    {
        $this->wholesaleFactory = $wholesaleFactory;
        $this->transportBuilder = $transportBuilder;
        $this->productRepository = $productRepository;
        parent::__construct($context);
    }

    public function execute()
    {
        $wholesaleId = $this->getRequest()->getParam('wholesale_id', false);
        $wholesale = $this->wholesaleFactory->create()->load($wholesaleId);
        $resultRedirect = $this->resultRedirectFactory->create();

        try {
            if (!$wholesale->getWholesaleId()) {
                $this->messageManager->addErrorMessage(__('This wholesale contact no longer exists.'));
                return $resultRedirect->setPath('wholesale/index/view');
            }
            $templateOptions = [
                'area' => \Magento\Framework\App\Area::AREA_ADMINHTML,
                'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
            ];
            $product = $this->productRepository->getById($wholesale->getProductId());
            $templateVars = [
                'customerName' => $wholesale->getCustomerName(),
                'telephone' => $wholesale->getPhoneNumber(),
                'productName' => $product->getName(),
                'requestDate' => date('Y/m/d', (int)$wholesale->getCreatedAt())
            ];

            $sender = [
                'name' => 'Smart OSC Store',
                'email' => 'huynq8@smartosc.com'
            ];

            $transport = $this->transportBuilder->setTemplateIdentifier('wholesale_contact_email_template')
                ->setTemplateOptions($templateOptions)
                ->setTemplateVars($templateVars)
                ->setFrom($sender)
                ->addTo($wholesale->getEmail())
                ->getTransport();
            $transport->sendMessage();

            $wholesale->setStatus(1);
            $wholesale->save();

            $this->messageManager->addSuccessMessage(__('Email sent to customer successfully.'));
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage(__('Something went wrong while sending email to wholesale customer.'));
            return $resultRedirect->setPath('wholesale/index/view');
        }

        return $resultRedirect->setPath('wholesale/index/view');
    }
}
