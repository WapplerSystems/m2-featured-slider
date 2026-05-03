<?php
declare(strict_types=1);

namespace WapplerSystems\FeaturedSlider\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Slide extends AbstractDb
{
    protected function _construct(): void
    {
        $this->_init('wapplersystems_featuredslider_slide', 'slide_id');
    }
}
