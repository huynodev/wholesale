<?php

namespace Dev\Wholesale\Ui\Component\Listing\Columns;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Escaper;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class WholesaleActions extends Column
{
    const WHOLESALE_URL_PATH_VIEW = 'wholesale/view/detail';


    protected $urlBuilder;
    private $detailUrl;
    private $escaper;

    public function __construct(
        ContextInterface                            $context,
        UiComponentFactory                          $uiComponentFactory,
        UrlInterface                                $urlBuilder,
        array                                       $components = [],
        array                                       $data = [],
                                                    $detailUrl = self::WHOLESALE_URL_PATH_VIEW,
        \Magento\Cms\ViewModel\Page\Grid\UrlBuilder $scopeUrlBuilder = null
    )
    {
        $this->urlBuilder = $urlBuilder;
        $this->detailUrl = $detailUrl;
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->scopeUrlBuilder = $scopeUrlBuilder ?: ObjectManager::getInstance()
            ->get(\Magento\Cms\ViewModel\Page\Grid\UrlBuilder::class);
    }

    /**
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $name = $this->getData('name');
                if (isset($item['wholesale_id'])) {
                    $item[$name]['view'] = [
                        'href' => $this->urlBuilder->getUrl($this->detailUrl, ['wholesale_id' => $item['wholesale_id']]),
                        'label' => __('View'),
                    ];
                }
            }
        }

        return $dataSource;
    }

    /**
     * @return Escaper|mixed
     */
    private function getEscaper()
    {
        if (!$this->escaper) {
            $this->escaper = ObjectManager::getInstance()->get(Escaper::class);
        }
        return $this->escaper;
    }
}
