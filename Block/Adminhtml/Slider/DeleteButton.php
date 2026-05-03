<?php
declare(strict_types=1);

namespace WapplerSystems\FeaturedSlider\Block\Adminhtml\Slider;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class DeleteButton extends GenericButton implements ButtonProviderInterface
{
    public function getButtonData(): array
    {
        if (!$this->getSliderId()) {
            return [];
        }
        return [
            'label' => __('Delete'),
            'class' => 'delete',
            'on_click' => sprintf(
                "deleteConfirm('%s', '%s')",
                __('Are you sure you want to delete this slider?'),
                $this->getUrl('*/*/delete', ['slider_id' => $this->getSliderId()])
            ),
            'sort_order' => 20,
        ];
    }
}
