<?php
declare(strict_types=1);

namespace WapplerSystems\FeaturedSlider\Controller\Adminhtml\Slide;

use WapplerSystems\FeaturedSlider\Controller\Adminhtml\Slide as SlideController;

class Index extends SlideController
{
    public function execute()
    {
        $page = $this->resultPageFactory->create();
        $this->initPage($page);
        $page->getConfig()->getTitle()->prepend(__('Slides'));
        return $page;
    }
}
