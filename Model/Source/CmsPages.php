<?php
declare(strict_types=1);

namespace WapplerSystems\FeaturedSlider\Model\Source;

use Magento\Cms\Model\ResourceModel\Page\CollectionFactory;
use Magento\Framework\Data\OptionSourceInterface;

class CmsPages implements OptionSourceInterface
{
    public function __construct(private readonly CollectionFactory $pageCollectionFactory) {}

    public function toOptionArray(): array
    {
        $options = [['value' => '', 'label' => __('-- None --')]];
        $collection = $this->pageCollectionFactory->create()
            ->addFieldToSelect(['title', 'identifier', 'is_active'])
            ->addFieldToFilter('is_active', 1)
            ->setOrder('title', 'asc');

        foreach ($collection as $page) {
            $options[] = [
                'value' => (int)$page->getId(),
                'label' => sprintf('%s (%s)', $page->getTitle(), $page->getIdentifier()),
            ];
        }
        return $options;
    }
}
