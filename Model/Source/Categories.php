<?php
declare(strict_types=1);

namespace WapplerSystems\FeaturedSlider\Model\Source;

use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;
use Magento\Framework\Data\OptionSourceInterface;
use Magento\Store\Model\StoreManagerInterface;

class Categories implements OptionSourceInterface
{
    public function __construct(
        private readonly CollectionFactory $categoryCollectionFactory,
        private readonly StoreManagerInterface $storeManager
    ) {}

    public function toOptionArray(): array
    {
        $options = [['value' => '', 'label' => __('-- None --')]];
        $rootId = (int)$this->storeManager->getStore()->getRootCategoryId();

        $collection = $this->categoryCollectionFactory->create()
            ->addAttributeToSelect(['name', 'is_active'])
            ->addAttributeToFilter('entity_id', ['neq' => 1])
            ->setOrder('path', 'asc');

        foreach ($collection as $category) {
            $level = max(0, (int)$category->getLevel() - 2);
            $name = str_repeat('— ', $level) . (string)$category->getName();
            if (!$category->getName()) {
                continue;
            }
            $options[] = [
                'value' => (int)$category->getId(),
                'label' => sprintf('%s (ID %d)', $name, $category->getId()),
            ];
        }
        return $options;
    }
}
