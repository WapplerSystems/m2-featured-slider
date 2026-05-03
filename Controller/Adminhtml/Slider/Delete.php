<?php
declare(strict_types=1);

namespace WapplerSystems\FeaturedSlider\Controller\Adminhtml\Slider;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use WapplerSystems\FeaturedSlider\Api\SliderRepositoryInterface;

class Delete extends Action
{
    public const ADMIN_RESOURCE = 'WapplerSystems_FeaturedSlider::slider';

    public function __construct(
        Context $context,
        private readonly SliderRepositoryInterface $sliderRepository
    ) {
        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = (int)$this->getRequest()->getParam('slider_id');
        try {
            $this->sliderRepository->deleteById($id);
            $this->messageManager->addSuccessMessage(__('Slider deleted.'));
        } catch (\Throwable $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }
        return $resultRedirect->setPath('*/*/');
    }
}
