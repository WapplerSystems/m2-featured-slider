<?php
declare(strict_types=1);

namespace WapplerSystems\FeaturedSlider\Model\Slide;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Filesystem;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use WapplerSystems\FeaturedSlider\Controller\Adminhtml\Slide\Upload;
use WapplerSystems\FeaturedSlider\Model\ResourceModel\Slide\CollectionFactory;

class DataProvider extends AbstractDataProvider
{
    private array $loadedData = [];

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        private readonly DataPersistorInterface $dataPersistor,
        private readonly StoreManagerInterface $storeManager,
        private readonly Filesystem $filesystem,
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
        foreach ($this->collection->getItems() as $slide) {
            $data = $slide->getData();
            $data['image'] = $this->buildImageMeta((string)$slide->getImage());
            $this->loadedData[$slide->getId()] = $data;
        }
        $persisted = $this->dataPersistor->get('featuredslider_slide');
        if (!empty($persisted)) {
            $slide = $this->collection->getNewEmptyItem();
            $slide->setData($persisted);
            $this->loadedData[$slide->getId() ?: ''] = $slide->getData();
            $this->dataPersistor->clear('featuredslider_slide');
        }
        return $this->loadedData;
    }

    private function buildImageMeta(string $imagePath): array
    {
        if ($imagePath === '') {
            return [];
        }
        $mediaDir = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA);
        $absPath = $mediaDir->getAbsolutePath($imagePath);
        $size = file_exists($absPath) ? filesize($absPath) : 0;

        return [[
            'name' => basename($imagePath),
            'url' => $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . $imagePath,
            'size' => $size,
            'type' => 'image',
        ]];
    }
}
