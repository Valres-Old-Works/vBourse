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
     * @param string $displayName
     */
    public function setDisplayName(string $displayName): void
    {
        $this->displayName = $displayName;
    }

    /**
     * @return string
     */
    public function getImageTexture(): string
    {
        return $this->imageTexture;
    }

    /**
     * @param string $imageTexture
     */
    public function setImageTexture(string $imageTexture): void
    {
        $this->imageTexture = $imageTexture;
    }

    /**
     * @return int
     */
    public function getMin(): int
    {
        return $this->min;
    }

    /**
     * @param int $min
     */
    public function setMin(int $min): void
    {
        $this->min = $min;
    }

    /**
     * @return int
     */
    public function getMax(): int
    {
        return $this->max;
    }

    /**
     * @param int $max
     */
    public function setMax(int $max): void
    {
        $this->max = $max;
    }

    /**
     * @return int
     */
    public function getActual(): int
    {
        return $this->actual;
    }

    /**
     * @param int $actual
     */
    public function setActual(int $actual): void
    {
        $this->actual = $actual;
    }
}