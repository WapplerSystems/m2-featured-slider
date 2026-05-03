<?php
declare(strict_types=1);

namespace WapplerSystems\FeaturedSlider\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;
use WapplerSystems\FeaturedSlider\Api\Data\SlideInterface;

class ContentType implements OptionSourceInterface
{
    public function toOptionArray(): array
    {
        return [
            ['value' => SlideInterface::TYPE_URL, 'label' => __('Custom URL')],
            ['value' => SlideInterface::TYPE_PRODUCT, 'label' => __('Product')],
            ['value' => SlideInterface::TYPE_CATEGORY, 'label' => __('Category')],
            ['value' => SlideInterface::TYPE_CMS_PAGE, 'label' => __('CMS Page')],
        ];
    }
}
