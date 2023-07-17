<?php

namespace Dev\Wholesale\Model\Wholesale;

use Dev\Wholesale\Model\ResourceModel\Wholesale\CollectionFactory;
use Magento\Store\Model\StoreManagerInterface;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected $collection;
    protected $loadedData;

    protected $storeManager;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $wholesaleCollectionFactory,
        storeManagerInterface $storeManager,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Catalog\Helper\Image $imageHelper,
        array $meta = [],
        array $data = []
    )
    {
        $this->storeManager = $storeManager;
        $this->collection = $wholesaleCollectionFactory->create();
        $this->productRepository = $productRepository;
        $this->imageHelper = $imageHelper;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->meta = $this->prepareMeta($this->meta);
    }

    public function prepareMeta(array $meta)
    {
        return $meta;
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $wholesale) {
            $data = $wholesale->getData();
            $product = $this->productRepository->getById($data['product_id']);
            $imageHelper = $this->imageHelper->init($product, 'product_listing_thumbnail_preview');
            $data['imageUpload'][0]['url'] = $imageHelper->getUrl();
            $data['imageUpload'][0]['name'] = $imageHelper->getLabel();
            $this->loadedData[$wholesale->getId()] = $data;
        }
        return $this->loadedData;
    }
}
