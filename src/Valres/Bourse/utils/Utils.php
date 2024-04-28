<?php

namespace Valres\Bourse\utils;

use pocketmine\item\Item;
use pocketmine\item\StringToItemParser;
use pocketmine\player\Player;

class Utils
{
    public static function getItemAmount(Player $player, Item $item): int
    {
        $amount = 0;
        foreach($player->getInventory()->getContents() as $slot => $item_){
            if($item_->getTypeId() === $item->getTypeId()){
                $amount += $item_->getCount();
            }
        }
        return $amount;
    }

    /**
     * @param Player $player
     * @return array
     */
    public static function getAllItemInInvInString(Player $player): array
    {
        $items = [];
        foreach($player->getInventory()->getContents() as $slot => $item_){
            $items[] = StringToItemParser::getInstance()->lookupAliases($item_)[0];
        }
        return $items;
    }
}
