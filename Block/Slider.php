<?php
declare(strict_types=1);

namespace WapplerSystems\FeaturedSlider\Block;

use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Url\Helper\Data as UrlHelper;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\StoreManagerInterface;
use WapplerSystems\FeaturedSlider\Api\Data\SlideInterface;
use WapplerSystems\FeaturedSlider\Api\Data\SliderInterface;
use WapplerSystems\FeaturedSlider\Api\SliderRepositoryInterface;
use WapplerSystems\FeaturedSlider\Model\ResourceModel\Slide\CollectionFactory as SlideCollectionFactory;

class Slider extends Template
{
    protected $_template = 'WapplerSystems_FeaturedSlider::widget/slider.phtml';

    public function __construct(
        Context $context,
        private readonly SliderRepositoryInterface $sliderRepository,
        private readonly SlideCollectionFactory $slideCollectionFactory,
        private readonly StoreManagerInterface $storeManager,
        private readonly ProductRepositoryInterface $productRepository,
        private readonly CategoryRepositoryInterface $categoryRepository,
        private readonly PageRepositoryInterface $pageRepository,
        private readonly UrlHelper $urlHelper,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    public function getSlider(): ?SliderInterface
    {
        if ($this->hasData('slider_object')) {
            return $this->getData('slider_object');
        }
        $identifier = (string)$this->getData('identifier');
        if ($identifier === '') {
            return null;
        }
        try {
            $slider = $this->sliderRepository->getByIdentifier($identifier);
        } catch (NoSuchEntityException $e) {
            return null;
        }
        if (!$slider->getIsActive()) {
            return null;
        }
        $stores = $slider->getStores();
        $currentStore = (int)$this->storeManager->getStore()->getId();
        if (!empty($stores) && !in_array(0, $stores, true) && !in_array($currentStore, $stores, true)) {
            return null;
        }
        $this->setData('slider_object', $slider);
        return $slider;
    }

    /**
     * @return SlideInterface[]
     */
    public function getSlides(): array
    {
        $slider = $this->getSlider();
        if (!$slider) {
            return [];
        }
        $collection = $this->slideCollectionFactory->create()
            ->addSliderFilter((int)$slider->getId())
            ->addActiveFilter();
        return array_values($collection->getItems());
    }

    /**
     * Widget parameter "show_title"; defaults to on so existing widgets keep their heading.
     */
    public function isTitleVisible(): bool
    {
        $value = $this->getData('show_title');
        return $value === null || $value === '' || (bool)(int)$value;
    }

    public function getDomId(): string
    {
        $slider = $this->getSlider();
        return 'fslider-' . ($slider ? $slider->getIdentifier() : 'unknown') . '-' . $this->getNameInLayout();
    }

    public function getSwiperConfigJson(): string
    {
        $slider = $this->getSlider();
        if (!$slider) {
            return '{}';
        }
        $slideCount = count($this->getSlides());
        // Swiper can only loop when there are more slides than fit into the view. Every breakpoint sets
        // "loop" explicitly, because Swiper keeps the previous breakpoint's value for keys a breakpoint omits.
        $view = static function (int $perView) use ($slider, $slideCount): array {
            return [
                'slidesPerView' => $perView,
                'loop' => $slider->getLoop() && $slideCount > $perView,
            ];
        };
        $mobile = $view($slider->getSlidesPerViewMobile());
        return (string)json_encode([
            'loop' => $mobile['loop'],
            'autoplay' => $slider->getAutoplay() ? ['delay' => $slider->getAutoplayDelay()] : false,
            'pagination' => $slider->getShowPagination(),
            'navigation' => $slider->getShowNavigation(),
            'slidesPerView' => $mobile['slidesPerView'],
            'spaceBetween' => $slider->getSpaceBetween(),
            'breakpoints' => [
                0 => $mobile,
                768 => $view(max(2, (int)floor($slider->getSlidesPerView() / 2) ?: 2)),
                1024 => $view($slider->getSlidesPerView()),
                1280 => $view($slider->getSlidesPerViewLarge()),
                1600 => $view($slider->getSlidesPerViewXlarge()),
            ],
        ], JSON_UNESCAPED_SLASHES);
    }

    public function getImageUrl(SlideInterface $slide): ?string
    {
        $path = $slide->getImage();
        if (!$path) {
            return null;
        }
        if (preg_match('#^(https?:)?//#', $path)) {
            return $path;
        }
        return $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . ltrim($path, '/');
    }

    public function getSlideLink(SlideInterface $slide): ?string
    {
        try {
            switch ($slide->getContentType()) {
                case SlideInterface::TYPE_PRODUCT:
                    if ($slide->getLinkProductId()) {
                        return $this->productRepository->getById($slide->getLinkProductId())->getProductUrl();
                    }
                    return null;
                case SlideInterface::TYPE_CATEGORY:
                    if ($slide->getLinkCategoryId()) {
                        return $this->categoryRepository->get($slide->getLinkCategoryId())->getUrl();
                    }
                    return null;
                case SlideInterface::TYPE_CMS_PAGE:
                    if ($slide->getLinkCmsPageId()) {
                        $page = $this->pageRepository->getById($slide->getLinkCmsPageId());
                        return $this->getUrl(null, ['_direct' => $page->getIdentifier()]);
                    }
                    return null;
                case SlideInterface::TYPE_URL:
                default:
                    return $slide->getLinkUrl() ?: null;
            }
        } catch (NoSuchEntityException $e) {
            return null;
        }
    }

    public function getCacheKeyInfo(): array
    {
        $slider = $this->getSlider();
        return array_merge(parent::getCacheKeyInfo(), [
            'fslider',
            $slider ? $slider->getId() : 'none',
            (int)$this->isTitleVisible(),
            (int)$this->storeManager->getStore()->getId(),
        ]);
    }
}
