<?php
declare(strict_types=1);

namespace WapplerSystems\FeaturedSlider\Api\Data;

interface SliderInterface
{
    public const SLIDER_ID = 'slider_id';
    public const TITLE = 'title';
    public const IDENTIFIER = 'identifier';
    public const IS_ACTIVE = 'is_active';
    public const AUTOPLAY = 'autoplay';
    public const AUTOPLAY_DELAY = 'autoplay_delay';
    public const LOOP = 'loop';
    public const SHOW_PAGINATION = 'show_pagination';
    public const SHOW_NAVIGATION = 'show_navigation';
    public const SLIDES_PER_VIEW = 'slides_per_view';
    public const SLIDES_PER_VIEW_MOBILE = 'slides_per_view_mobile';
    public const SLIDES_PER_VIEW_LARGE = 'slides_per_view_large';
    public const SLIDES_PER_VIEW_XLARGE = 'slides_per_view_xlarge';
    public const SPACE_BETWEEN = 'space_between';
    public const STORES = 'stores';

    public function getSliderId(): ?int;
    public function setSliderId(int $id): self;

    public function getTitle(): ?string;
    public function setTitle(string $title): self;

    public function getIdentifier(): ?string;
    public function setIdentifier(string $identifier): self;

    public function getIsActive(): bool;
    public function setIsActive(bool $isActive): self;

    public function getAutoplay(): bool;
    public function getAutoplayDelay(): int;
    public function getLoop(): bool;
    public function getShowPagination(): bool;
    public function getShowNavigation(): bool;
    public function getSlidesPerView(): int;
    public function getSlidesPerViewMobile(): int;
    public function getSlidesPerViewLarge(): int;
    public function getSlidesPerViewXlarge(): int;
    public function getSpaceBetween(): int;

    /**
     * @return int[]
     */
    public function getStores(): array;

    /**
     * @param int[] $storeIds
     */
    public function setStores(array $storeIds): self;
}
