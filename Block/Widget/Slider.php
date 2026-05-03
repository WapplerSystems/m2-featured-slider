<?php
declare(strict_types=1);

namespace WapplerSystems\FeaturedSlider\Block\Widget;

use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Framework\Url\Helper\Data as UrlHelper;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\View\Element\Template;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Widget\Block\BlockInterface;
use WapplerSystems\FeaturedSlider\Api\SliderRepositoryInterface;
use WapplerSystems\FeaturedSlider\Block\Slider as SliderBlock;
use WapplerSystems\FeaturedSlider\Model\ResourceModel\Slide\CollectionFactory as SlideCollectionFactory;

class Slider extends SliderBlock implements BlockInterface
{
    public function __construct(
        Context $context,
        SliderRepositoryInterface $sliderRepository,
        SlideCollectionFactory $slideCollectionFactory,
        StoreManagerInterface $storeManager,
        ProductRepositoryInterface $productRepository,
        CategoryRepositoryInterface $categoryRepository,
        PageRepositoryInterface $pageRepository,
        UrlHelper $urlHelper,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $sliderRepository,
            $slideCollectionFactory,
            $storeManager,
            $productRepository,
            $categoryRepository,
            $pageRepository,
            $urlHelper,
            $data
        );
    }
}
