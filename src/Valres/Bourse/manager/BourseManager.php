<?php

namespace Valres\Bourse\manager;

use pocketmine\item\StringToItemParser;
use Valres\Bourse\Bourse;

class BourseManager
{
    /** @var BourseItem[] */
    private array $bourse = [];

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

    public function getAllBourse(): array
    {
        return $this->bourse;
    }
}
