<?php
declare(strict_types=1);

namespace WapplerSystems\FeaturedSlider\Controller\Adminhtml\Slider;

use WapplerSystems\FeaturedSlider\Controller\Adminhtml\Slider as SliderController;
use WapplerSystems\FeaturedSlider\Model\SliderFactory;

class Edit extends SliderController
{
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $coreRegistry,
        private readonly SliderFactory $sliderFactory
    ) {
        parent::__construct($context, $resultPageFactory, $coreRegistry);
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('slider_id');
        $slider = $this->sliderFactory->create();
        if ($id) {
            $slider->load($id);
            if (!$slider->getId()) {
                $this->messageManager->addErrorMessage(__('This slider no longer exists.'));
                return $this->resultRedirectFactory->create()->setPath('*/*/');
            }
        }
        $this->coreRegistry->register('featuredslider_slider', $slider);

        $page = $this->resultPageFactory->create();
        $this->initPage($page);
        $page->addBreadcrumb($id ? __('Edit Slider') : __('New Slider'), $id ? __('Edit Slider') : __('New Slider'));
        $page->getConfig()->getTitle()->prepend($id ? $slider->getTitle() : __('New Slider'));
        return $page;
    }
}
