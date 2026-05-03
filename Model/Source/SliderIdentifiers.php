<?php
declare(strict_types=1);

namespace WapplerSystems\FeaturedSlider\Model\Source;

use Magento\Framework\Option\ArrayInterface;
use WapplerSystems\FeaturedSlider\Model\ResourceModel\Slider\CollectionFactory;

class SliderIdentifiers implements ArrayInterface
{
    public function __construct(private readonly CollectionFactory $collectionFactory) {}

    public function toOptionArray(): array
    {
        $options = [];
        foreach ($this->collectionFactory->create()->addFieldToFilter('is_active', 1) as $slider) {
            $options[] = [
                'value' => $slider->getIdentifier(),
                'label' => sprintf('%s (%s)', $slider->getTitle(), $slider->getIdentifier()),
            ];
        }
        return $options;
    }
}
