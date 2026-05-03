<?php
declare(strict_types=1);

namespace WapplerSystems\FeaturedSlider\Api\Data;

interface SlideInterface
{
    public const SLIDE_ID = 'slide_id';
    public const SLIDER_ID = 'slider_id';
    public const TITLE = 'title';
    public const SUBTITLE = 'subtitle';
    public const DESCRIPTION = 'description';
    public const IMAGE = 'image';
    public const IMAGE_ALT = 'image_alt';
    public const CONTENT_TYPE = 'content_type';
    public const LINK_URL = 'link_url';
    public const LINK_PRODUCT_ID = 'link_product_id';
    public const LINK_CATEGORY_ID = 'link_category_id';
    public const LINK_CMS_PAGE_ID = 'link_cms_page_id';
    public const LINK_TARGET = 'link_target';
    public const SORT_ORDER = 'sort_order';
    public const IS_ACTIVE = 'is_active';
    public const ACTIVE_FROM = 'active_from';
    public const ACTIVE_TO = 'active_to';

    public const TYPE_URL = 'url';
    public const TYPE_PRODUCT = 'product';
    public const TYPE_CATEGORY = 'category';
    public const TYPE_CMS_PAGE = 'cms_page';

    public function getSlideId(): ?int;
    public function setSlideId(int $id): self;

    public function getSliderId(): ?int;
    public function setSliderId(int $sliderId): self;

    public function getTitle(): ?string;
    public function setTitle(string $title): self;

    public function getSubtitle(): ?string;
    public function getDescription(): ?string;
    public function getImage(): ?string;
    public function getImageAlt(): ?string;

    public function getContentType(): string;
    public function getLinkUrl(): ?string;
    public function getLinkProductId(): ?int;
    public function getLinkCategoryId(): ?int;
    public function getLinkCmsPageId(): ?int;
    public function getLinkTarget(): string;

    public function getSortOrder(): int;
    public function getIsActive(): bool;
    public function getActiveFrom(): ?string;
    public function getActiveTo(): ?string;
}
