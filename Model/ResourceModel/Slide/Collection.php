<?php
declare(strict_types=1);

namespace WapplerSystems\FeaturedSlider\Model\ResourceModel\Slide;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use WapplerSystems\FeaturedSlider\Model\Slide as SlideModel;
use WapplerSystems\FeaturedSlider\Model\ResourceModel\Slide as SlideResource;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'slide_id';

    protected function _construct(): void
    {
        $this->_init(SlideModel::class, SlideResource::class);
    }

    public function addSliderFilter(int $sliderId): self
    {
        $this->addFieldToFilter('slider_id', $sliderId);
        return $this;
    }

    public function addActiveFilter(): self
    {
        $this->addFieldToFilter('is_active', 1);
        $now = (new \DateTime())->format('Y-m-d H:i:s');
        $this->addFieldToFilter(
            ['active_from', 'active_from'],
            [['null' => true], ['lteq' => $now]]
        );
        $this->addFieldToFilter(
            ['active_to', 'active_to'],
            [['null' => true], ['gteq' => $now]]
        );
        $this->setOrder('sort_order', self::SORT_ORDER_ASC);
        return $this;
    }
}
