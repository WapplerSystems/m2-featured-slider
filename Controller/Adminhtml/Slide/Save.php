<?php
declare(strict_types=1);

namespace WapplerSystems\FeaturedSlider\Controller\Adminhtml\Slide;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use WapplerSystems\FeaturedSlider\Model\SlideFactory;
use WapplerSystems\FeaturedSlider\Api\SlideRepositoryInterface;

class Save extends Action
{
    public const ADMIN_RESOURCE = 'WapplerSystems_FeaturedSlider::slide';

    public function __construct(
        Context $context,
        private readonly SlideFactory $slideFactory,
        private readonly SlideRepositoryInterface $slideRepository,
        private readonly DataPersistorInterface $dataPersistor
    ) {
        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if (!$data) {
            return $resultRedirect->setPath('*/*/');
        }

        // image upload via Magento UI Image uploader: data['image'] is array on new upload
        if (isset($data['image']) && is_array($data['image'])) {
            $data['image'] = $data['image'][0]['url'] ?? ($data['image'][0]['name'] ?? null);
        }

        foreach (['active_from', 'active_to'] as $dateField) {
            if (isset($data[$dateField]) && $data[$dateField] === '') {
                $data[$dateField] = null;
            }
        }
        foreach (['link_product_id', 'link_category_id', 'link_cms_page_id'] as $fk) {
            if (isset($data[$fk]) && $data[$fk] === '') {
                $data[$fk] = null;
            }
        }

        $id = (int)($data['slide_id'] ?? 0);
        try {
            $slide = $id ? $this->slideRepository->getById($id) : $this->slideFactory->create();
            $slide->addData($data);
            $this->slideRepository->save($slide);
            $this->messageManager->addSuccessMessage(__('Slide saved.'));
            $this->dataPersistor->clear('featuredslider_slide');

            if ($this->getRequest()->getParam('back')) {
                return $resultRedirect->setPath('*/*/edit', ['slide_id' => $slide->getId()]);
            }
            return $resultRedirect->setPath('*/*/');
        } catch (\Throwable $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            $this->dataPersistor->set('featuredslider_slide', $data);
            return $resultRedirect->setPath('*/*/edit', ['slide_id' => $id]);
        }
    }
}
