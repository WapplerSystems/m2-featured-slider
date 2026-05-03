<?php
declare(strict_types=1);

namespace WapplerSystems\FeaturedSlider\Model;

use Magento\Framework\Model\AbstractModel;
use WapplerSystems\FeaturedSlider\Api\Data\SlideInterface;
use WapplerSystems\FeaturedSlider\Model\ResourceModel\Slide as SlideResource;

class Slide extends AbstractModel implements SlideInterface
{
    protected $_eventPrefix = 'wapplersystems_featuredslider_slide';

    protected function _construct(): void
    {
        $this->_init(SlideResource::class);
    }

    public function getSlideId(): ?int
    {
        $id = $this->getData(self::SLIDE_ID);
        return $id !== null ? (int)$id : null;
    }

    public function setSlideId(int $id): self
    {
        return $this->setData(self::SLIDE_ID, $id);
    }

    public function getSliderId(): ?int
    {
        $id = $this->getData(self::SLIDER_ID);
        return $id !== null ? (int)$id : null;
    }

    public function setSliderId(int $sliderId): self
    {
        return $this->setData(self::SLIDER_ID, $sliderId);
    }

    public function getTitle(): ?string
    {
        return $this->getData(self::TITLE);
    }

    public function setTitle(string $title): self
    {
        return $this->setData(self::TITLE, $title);
    }

    public function getSubtitle(): ?string
    {
        return $this->getData(self::SUBTITLE);
    }

    public function getDescription(): ?string
    {
        return $this->getData(self::DESCRIPTION);
    }

    public function getImage(): ?string
    {
        return $this->getData(self::IMAGE);
    }

    public function getImageAlt(): ?string
    {
        return $this->getData(self::IMAGE_ALT);
    }

    public function getContentType(): string
    {
        return (string)($this->getData(self::CONTENT_TYPE) ?: self::TYPE_URL);
    }

    public function getLinkUrl(): ?string
    {
        return $this->getData(self::LINK_URL);
    }

    public function getLinkProductId(): ?int
    {
        $id = $this->getData(self::LINK_PRODUCT_ID);
        return $id !== null ? (int)$id : null;
    }

    public function getLinkCategoryId(): ?int
    {
        $id = $this->getData(self::LINK_CATEGORY_ID);
        return $id !== null ? (int)$id : null;
    }

    public function getLinkCmsPageId(): ?int
    {
        $id = $this->getData(self::LINK_CMS_PAGE_ID);
        return $id !== null ? (int)$id : null;
    }

    public function getLinkTarget(): string
    {
        return (string)($this->getData(self::LINK_TARGET) ?: '_self');
    }

    public function getSortOrder(): int
    {
        return (int)$this->getData(self::SORT_ORDER);
    }

    public function getIsActive(): bool
    {
        return (bool)$this->getData(self::IS_ACTIVE);
    }

    public function getActiveFrom(): ?string
    {
        return $this->getData(self::ACTIVE_FROM);
    }

    public function getActiveTo(): ?string
    {
        return $this->getData(self::ACTIVE_TO);
    }
}
