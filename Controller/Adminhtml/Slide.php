<?php
declare(strict_types=1);

namespace WapplerSystems\FeaturedSlider\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Registry;

abstract class Slide extends Action
{
    public const ADMIN_RESOURCE = 'WapplerSystems_FeaturedSlider::slide';

    public function __construct(
        Context $context,
        protected readonly PageFactory $resultPageFactory,
        protected readonly Registry $coreRegistry
    ) {
        parent::__construct($context);
    }

    protected function initPage($resultPage)
    {
        $resultPage->setActiveMenu('WapplerSystems_FeaturedSlider::slide_list')
            ->addBreadcrumb(__('Featured Slider'), __('Featured Slider'))
            ->addBreadcrumb(__('Slides'), __('Slides'));
        return $resultPage;
    }
}
