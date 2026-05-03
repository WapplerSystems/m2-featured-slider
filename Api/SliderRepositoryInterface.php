<?php
declare(strict_types=1);

namespace WapplerSystems\FeaturedSlider\Api;

use WapplerSystems\FeaturedSlider\Api\Data\SliderInterface;

interface SliderRepositoryInterface
{
    public function save(SliderInterface $slider): SliderInterface;

    public function getById(int $id): SliderInterface;

    public function getByIdentifier(string $identifier): SliderInterface;

    public function delete(SliderInterface $slider): bool;

    public function deleteById(int $id): bool;
}
