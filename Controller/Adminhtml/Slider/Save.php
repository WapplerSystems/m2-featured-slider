<?php
declare(strict_types=1);

namespace WapplerSystems\FeaturedSlider\Controller\Adminhtml\Slider;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use WapplerSystems\FeaturedSlider\Model\SliderFactory;
use WapplerSystems\FeaturedSlider\Api\SliderRepositoryInterface;

class Save extends Action
{
    public const ADMIN_RESOURCE = 'WapplerSystems_FeaturedSlider::slider';

    public function __construct(
        Context $context,
        private readonly SliderFactory $sliderFactory,
        private readonly SliderRepositoryInterface $sliderRepository,
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

        $id = (int)($data['slider_id'] ?? 0);
        try {
            $slider = $id ? $this->sliderRepository->getById($id) : $this->sliderFactory->create();
            $slider->addData($data);
            if (!empty($data['stores'])) {
                $slider->setStores(array_map('intval', (array)$data['stores']));
            }
            $this->sliderRepository->save($slider);
            $this->messageManager->addSuccessMessage(__('Slider saved.'));
            $this->dataPersistor->clear('featuredslider_slider');

            if ($this->getRequest()->getParam('back')) {
                return $resultRedirect->setPath('*/*/edit', ['slider_id' => $slider->getId()]);
            }
            return $resultRedirect->setPath('*/*/');
        } catch (\Throwable $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            $this->dataPersistor->set('featuredslider_slider', $data);
            return $resultRedirect->setPath('*/*/edit', ['slider_id' => $id]);
        }
    }
}
