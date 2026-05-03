<?php
declare(strict_types=1);

namespace WapplerSystems\FeaturedSlider\Model\Slider;

use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use WapplerSystems\FeaturedSlider\Model\ResourceModel\Slider\CollectionFactory;

class DataProvider extends AbstractDataProvider
{
    private array $loadedData = [];

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        private readonly DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
    }

    public function getData(): array
    {
        if (!empty($this->loadedData)) {
            return $this->loadedData;
        }
        foreach ($this->collection->getItems() as $slider) {
            $data = $slider->getData();
            $data['stores'] = $slider->getStores();
            $this->loadedData[$slider->getId()] = $data;
        }
        $persisted = $this->dataPersistor->get('featuredslider_slider');
        if (!empty($persisted)) {
            $slider = $this->collection->getNewEmptyItem();
            $slider->setData($persisted);
            $this->loadedData[$slider->getId() ?: ''] = $slider->getData();
            $this->dataPersistor->clear('featuredslider_slider');
        }
        return $this->loadedData;
    }
}
