<?php
declare(strict_types=1);

namespace WapplerSystems\FeaturedSlider\Block\Adminhtml\Slide;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class DeleteButton extends GenericButton implements ButtonProviderInterface
{
    public function getButtonData(): array
    {
        if (!$this->getSlideId()) {
            return [];
        }
        return [
            'label' => __('Delete'),
            'class' => 'delete',
            'on_click' => sprintf(
                "deleteConfirm('%s', '%s')",
                __('Are you sure you want to delete this slide?'),
                $this->getUrl('*/*/delete', ['slide_id' => $this->getSlideId()])
            ),
            'sort_order' => 20,
        ];
    }
}
