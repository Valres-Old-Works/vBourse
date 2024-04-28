<?php

namespace Valres\Bourse\manager;

use JsonException;
use pocketmine\item\Item;
use pocketmine\item\StringToItemParser;
use Valres\Bourse\Bourse;

class BourseManager
{
    /** @var BourseItem[] */
    private array $bourse = [];

    /**
     * @throws JsonException
     */
    public function addBourseItem(Item $item, string $displayName, string $imageTexture, int $min, int $max): void
    {
        $this->bourse[] = new BourseItem(
            $item,
            $displayName,
            $imageTexture,
            $min,
            $max,
            rand($min, $max)
        );
        $this->saveBourse();
        $this->bourse = [];
        $this->loadBourse();
    }

    /**
     * @throws JsonException
     */
    public function removeBourseItem(int $data): void
    {
        unset($this->bourse[$data]);
        $this->saveBourse();
        $this->bourse = [];
        $this->loadBourse();
    }

    public function loadBourse(): void
    {
        $config = Bourse::getInstance()->getConfig();

        foreach($config->get("bourse") as $bourseItem => ["display_name" => $displayName, "image_texture" => $imageTexture, "min" => $min, "max" => $max]){
            $this->bourse[] = new BourseItem(
                StringToItemParser::getInstance()->parse($bourseItem),
                $displayName,
                $imageTexture,
                $min,
                $max,
                rand($min, $max)
            );
        }
    }

    /**
     * @throws JsonException
     */
    public function saveBourse(): void
    {
        $config = Bourse::getInstance()->getConfig();
        $config->set("bourse", []);
        $bourse = [];

        foreach($this->bourse as $bourseItem){
            $bourse[StringToItemParser::getInstance()->lookupAliases($bourseItem->getItem())[0]] = [
                "display_name" => $bourseItem->getDisplayName(),
                "image_texture" => $bourseItem->getImageTexture(),
                "min" => $bourseItem->getMin(),
                "max" => $bourseItem->getMax()
            ];
        }
        $config->set("bourse", $bourse);
        $config->save();
    }

    public function getAllBourse(): array
    {
        return $this->bourse;
    }
}
