<?php

namespace Valres\Bourse\utils;

use pocketmine\item\Item;
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
}
