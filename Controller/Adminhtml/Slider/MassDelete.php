<?php
declare(strict_types=1);

namespace WapplerSystems\FeaturedSlider\Controller\Adminhtml\Slider;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;
use WapplerSystems\FeaturedSlider\Model\ResourceModel\Slider\CollectionFactory;
use WapplerSystems\FeaturedSlider\Api\SliderRepositoryInterface;

class MassDelete extends Action
{
    public const ADMIN_RESOURCE = 'WapplerSystems_FeaturedSlider::slider';

    public function __construct(
        Context $context,
        private readonly Filter $filter,
        private readonly CollectionFactory $collectionFactory,
        private readonly SliderRepositoryInterface $repository
    ) {
        parent::__construct($context);
    }

    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $count = 0;
        foreach ($collection as $slider) {
            $this->repository->delete($slider);
            $count++;
        }
        $this->messageManager->addSuccessMessage(__('%1 slider(s) deleted.', $count));
        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('*/*/');
    }
}
