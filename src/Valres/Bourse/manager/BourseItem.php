<?php

namespace Valres\Bourse\manager;

use pocketmine\item\Item;

class BourseItem
{
    public function __construct(
        protected Item $item,
        protected string $displayName,
        protected string $imageTexture,
        protected int $min,
        protected int $max,
        protected int $actual
    ) {}

    /**
     * @return Item
     */
    public function getItem(): Item
    {
        return $this->item;
    }

    /**
     * @return string
     */
    public function getDisplayName(): string
    {
        return $this->displayName;
    }

    /**
     * @return string
     */
    public function getImageTexture(): string
    {
        return $this->imageTexture;
    }

    /**
     * @return int
     */
    public function getMin(): int
    {
        return $this->min;
    }

    /**
     * @return int
     */
    public function getMax(): int
    {
        return $this->max;
    }

    /**
     * @return int
     */
    public function getActual(): int
    {
        return $this->actual;
    }
}