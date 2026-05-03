<?php
declare(strict_types=1);

namespace WapplerSystems\FeaturedSlider\Block\Adminhtml\Slider;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\App\RequestInterface;

abstract class GenericButton
{
    public function __construct(
        protected readonly Context $context,
        protected readonly RequestInterface $request
    ) {}

    public function getSliderId(): ?int
    {
        $id = $this->request->getParam('slider_id');
        return $id ? (int)$id : null;
    }

    public function getUrl(string $route = '', array $params = []): string
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
