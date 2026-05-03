<?php
declare(strict_types=1);

namespace WapplerSystems\FeaturedSlider\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class SliderActions extends Column
{
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        private readonly UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $id = $item['slider_id'] ?? null;
                if (!$id) {
                    continue;
                }
                $item[$this->getData('name')] = [
                    'edit' => [
                        'href' => $this->urlBuilder->getUrl('featuredslider/slider/edit', ['slider_id' => $id]),
                        'label' => __('Edit'),
                    ],
                    'slides' => [
                        'href' => $this->urlBuilder->getUrl('featuredslider/slide/index', ['slider_id' => $id]),
                        'label' => __('Manage Slides'),
                    ],
                    'delete' => [
                        'href' => $this->urlBuilder->getUrl('featuredslider/slider/delete', ['slider_id' => $id]),
                        'label' => __('Delete'),
                        'confirm' => [
                            'title' => __('Delete "%1"', $item['title'] ?? ''),
                            'message' => __('Are you sure you want to delete this slider?'),
                        ],
                    ],
                ];
            }
        }
        return $dataSource;
    }
}
