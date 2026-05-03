<?php
declare(strict_types=1);

namespace WapplerSystems\FeaturedSlider\Controller\Adminhtml\Slide;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;
use WapplerSystems\FeaturedSlider\Model\ResourceModel\Slide\CollectionFactory;
use WapplerSystems\FeaturedSlider\Api\SlideRepositoryInterface;

class MassDelete extends Action
{
    public const ADMIN_RESOURCE = 'WapplerSystems_FeaturedSlider::slide';

    public function __construct(
        Context $context,
        private readonly Filter $filter,
        private readonly CollectionFactory $collectionFactory,
        private readonly SlideRepositoryInterface $repository
    ) {
        parent::__construct($context);
    }

    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $count = 0;
        foreach ($collection as $slide) {
            $this->repository->delete($slide);
            $count++;
        }
        $this->messageManager->addSuccessMessage(__('%1 slide(s) deleted.', $count));
        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('*/*/');
    }
}
