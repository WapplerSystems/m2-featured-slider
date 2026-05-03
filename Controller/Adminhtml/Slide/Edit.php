<?php
declare(strict_types=1);

namespace WapplerSystems\FeaturedSlider\Controller\Adminhtml\Slide;

use WapplerSystems\FeaturedSlider\Controller\Adminhtml\Slide as SlideController;
use WapplerSystems\FeaturedSlider\Model\SlideFactory;

class Edit extends SlideController
{
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $coreRegistry,
        private readonly SlideFactory $slideFactory
    ) {
        parent::__construct($context, $resultPageFactory, $coreRegistry);
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('slide_id');
        $slide = $this->slideFactory->create();
        if ($id) {
            $slide->load($id);
            if (!$slide->getId()) {
                $this->messageManager->addErrorMessage(__('This slide no longer exists.'));
                return $this->resultRedirectFactory->create()->setPath('*/*/');
            }
        }
        $this->coreRegistry->register('featuredslider_slide', $slide);

        $page = $this->resultPageFactory->create();
        $this->initPage($page);
        $page->getConfig()->getTitle()->prepend($id ? $slide->getTitle() : __('New Slide'));
        return $page;
    }
}
