<?php
declare(strict_types=1);

namespace WapplerSystems\FeaturedSlider\Model\ResourceModel\Slider;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use WapplerSystems\FeaturedSlider\Model\Slider as SliderModel;
use WapplerSystems\FeaturedSlider\Model\ResourceModel\Slider as SliderResource;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'slider_id';

    protected function _construct(): void
    {
        $this->_init(SliderModel::class, SliderResource::class);
    }

    public function addStoreFilter(int $storeId): self
    {
        $this->getSelect()->joinInner(
            ['ss' => $this->getTable('wapplersystems_featuredslider_slider_store')],
            'main_table.slider_id = ss.slider_id',
            []
        )->where('ss.store_id IN (?)', [0, $storeId])
            ->group('main_table.slider_id');
        return $this;
    }
}
