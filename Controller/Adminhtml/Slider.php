<?php
declare(strict_types=1);

namespace WapplerSystems\FeaturedSlider\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Registry;

abstract class Slider extends Action
{
    public const ADMIN_RESOURCE = 'WapplerSystems_FeaturedSlider::slider';

    public function __construct(
        Context $context,
        protected readonly PageFactory $resultPageFactory,
        protected readonly Registry $coreRegistry
    ) {
        parent::__construct($context);
    }

    protected function initPage($resultPage)
    {
        $resultPage->setActiveMenu('WapplerSystems_FeaturedSlider::slider_list')
            ->addBreadcrumb(__('Featured Slider'), __('Featured Slider'))
            ->addBreadcrumb(__('Sliders'), __('Sliders'));
        return $resultPage;
    }
}
