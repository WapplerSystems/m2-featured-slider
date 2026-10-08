<?php
declare(strict_types=1);

namespace WapplerSystems\FeaturedSlider\Model;

use Magento\Framework\Model\AbstractModel;
use WapplerSystems\FeaturedSlider\Api\Data\SliderInterface;
use WapplerSystems\FeaturedSlider\Model\ResourceModel\Slider as SliderResource;

class Slider extends AbstractModel implements SliderInterface
{
    protected $_eventPrefix = 'wapplersystems_featuredslider_slider';

    protected function _construct(): void
    {
        $this->_init(SliderResource::class);
    }

    public function getSliderId(): ?int
    {
        $id = $this->getData(self::SLIDER_ID);
        return $id !== null ? (int)$id : null;
    }

    public function setSliderId(int $id): self
    {
        return $this->setData(self::SLIDER_ID, $id);
    }

    public function getTitle(): ?string
    {
        return $this->getData(self::TITLE);
    }

    public function setTitle(string $title): self
    {
        return $this->setData(self::TITLE, $title);
    }

    public function getIdentifier(): ?string
    {
        return $this->getData(self::IDENTIFIER);
    }

    public function setIdentifier(string $identifier): self
    {
        return $this->setData(self::IDENTIFIER, $identifier);
    }

    public function getIsActive(): bool
    {
        return (bool)$this->getData(self::IS_ACTIVE);
    }

    public function setIsActive(bool $isActive): self
    {
        return $this->setData(self::IS_ACTIVE, $isActive ? 1 : 0);
    }

    public function getAutoplay(): bool
    {
        return (bool)$this->getData(self::AUTOPLAY);
    }

    public function getAutoplayDelay(): int
    {
        return (int)($this->getData(self::AUTOPLAY_DELAY) ?: 5000);
    }

    public function getLoop(): bool
    {
        return (bool)$this->getData(self::LOOP);
    }

    public function getShowPagination(): bool
    {
        return (bool)$this->getData(self::SHOW_PAGINATION);
    }

    public function getShowNavigation(): bool
    {
        return (bool)$this->getData(self::SHOW_NAVIGATION);
    }

    public function getSlidesPerView(): int
    {
        return (int)($this->getData(self::SLIDES_PER_VIEW) ?: 3);
    }

    public function getSlidesPerViewMobile(): int
    {
        return (int)($this->getData(self::SLIDES_PER_VIEW_MOBILE) ?: 1);
    }

    /**
     * Viewport >= 1280px; falls back to the desktop value when unset.
     */
    public function getSlidesPerViewLarge(): int
    {
        return (int)($this->getData(self::SLIDES_PER_VIEW_LARGE) ?: $this->getSlidesPerView());
    }

    /**
     * Viewport >= 1600px; falls back to the large value when unset.
     */
    public function getSlidesPerViewXlarge(): int
    {
        return (int)($this->getData(self::SLIDES_PER_VIEW_XLARGE) ?: $this->getSlidesPerViewLarge());
    }

    public function getSpaceBetween(): int
    {
        return (int)($this->getData(self::SPACE_BETWEEN) ?: 20);
    }

    public function getStores(): array
    {
        $stores = $this->getData(self::STORES);
        if (is_string($stores)) {
            $stores = explode(',', $stores);
        }
        return array_map('intval', (array)($stores ?: []));
    }

    public function setStores(array $storeIds): self
    {
        return $this->setData(self::STORES, $storeIds);
    }
}
