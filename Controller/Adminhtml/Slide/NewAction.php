<?php
declare(strict_types=1);

namespace WapplerSystems\FeaturedSlider\Controller\Adminhtml\Slide;

use WapplerSystems\FeaturedSlider\Controller\Adminhtml\Slide as SlideController;
use Magento\Framework\Controller\ResultFactory;

class NewAction extends SlideController
{
    public function execute()
    {
        return $this->resultFactory->create(ResultFactory::TYPE_FORWARD)->forward('edit');
    }
}
