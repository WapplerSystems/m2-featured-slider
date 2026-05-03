<?php
declare(strict_types=1);

namespace WapplerSystems\FeaturedSlider\Controller\Adminhtml\Slide;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use WapplerSystems\FeaturedSlider\Api\SlideRepositoryInterface;

class Delete extends Action
{
    public const ADMIN_RESOURCE = 'WapplerSystems_FeaturedSlider::slide';

    public function __construct(
        Context $context,
        private readonly SlideRepositoryInterface $slideRepository
    ) {
        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = (int)$this->getRequest()->getParam('slide_id');
        try {
            $this->slideRepository->deleteById($id);
            $this->messageManager->addSuccessMessage(__('Slide deleted.'));
        } catch (\Throwable $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }
        return $resultRedirect->setPath('*/*/');
    }
}
