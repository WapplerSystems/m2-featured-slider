<?php
declare(strict_types=1);

namespace WapplerSystems\FeaturedSlider\Model;

use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use WapplerSystems\FeaturedSlider\Api\Data\SliderInterface;
use WapplerSystems\FeaturedSlider\Api\SliderRepositoryInterface;
use WapplerSystems\FeaturedSlider\Model\ResourceModel\Slider as SliderResource;
use WapplerSystems\FeaturedSlider\Model\ResourceModel\Slider\CollectionFactory;

class SliderRepository implements SliderRepositoryInterface
{
    public function __construct(
        private readonly SliderResource $resource,
        private readonly SliderFactory $sliderFactory,
        private readonly CollectionFactory $collectionFactory
    ) {}

    public function save(SliderInterface $slider): SliderInterface
    {
        try {
            $this->resource->save($slider);
        } catch (\Throwable $e) {
            throw new CouldNotSaveException(__('Could not save slider: %1', $e->getMessage()), $e);
        }
        return $slider;
    }

    public function getById(int $id): SliderInterface
    {
        $slider = $this->sliderFactory->create();
        $this->resource->load($slider, $id);
        if (!$slider->getId()) {
            throw new NoSuchEntityException(__('Slider with id %1 not found.', $id));
        }
        return $slider;
    }

    public function getByIdentifier(string $identifier): SliderInterface
    {
        $collection = $this->collectionFactory->create();
        $slider = $collection->addFieldToFilter('identifier', $identifier)->getFirstItem();
        if (!$slider->getId()) {
            throw new NoSuchEntityException(__('Slider "%1" not found.', $identifier));
        }
        return $slider;
    }

    public function delete(SliderInterface $slider): bool
    {
        try {
            $this->resource->delete($slider);
        } catch (\Throwable $e) {
            throw new CouldNotDeleteException(__('Could not delete slider: %1', $e->getMessage()), $e);
        }
        return true;
    }

    public function deleteById(int $id): bool
    {
        return $this->delete($this->getById($id));
    }
}
