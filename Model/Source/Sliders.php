<?php
declare(strict_types=1);

namespace WapplerSystems\FeaturedSlider\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;
use WapplerSystems\FeaturedSlider\Model\ResourceModel\Slider\CollectionFactory;

class Sliders implements OptionSourceInterface
{
    public function __construct(private readonly CollectionFactory $collectionFactory) {}

    public function toOptionArray(): array
    {
        $options = [['value' => '', 'label' => __('-- Please Select --')]];
        foreach ($this->collectionFactory->create() as $slider) {
            $options[] = [
                'value' => $slider->getId(),
                'label' => sprintf('%s (%s)', $slider->getTitle(), $slider->getIdentifier()),
            ];
        }
        return $options;
    }
}
