<?php
declare(strict_types=1);

namespace WapplerSystems\FeaturedSlider\Controller\Adminhtml\Slider;

use WapplerSystems\FeaturedSlider\Controller\Adminhtml\Slider as SliderController;

class Index extends SliderController
{
    public function execute()
    {
        $page = $this->resultPageFactory->create();
        $this->initPage($page);
        $page->getConfig()->getTitle()->prepend(__('Sliders'));
        return $page;
    }
}
