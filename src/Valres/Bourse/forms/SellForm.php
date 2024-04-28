<?php

namespace Valres\Bourse\forms;

use pocketmine\player\Player;
use Valres\Bourse\Bourse;
use Valres\Bourse\libs\jojoe77777\FormAPI\CustomForm;
use Valres\Bourse\manager\BourseItem;
use Valres\Bourse\utils\Utils;

class SellForm
{
    public static function sendForm(Player $player, BourseItem $bourseItem): void
    {
        $form = new CustomForm(function(Player $player, array $data = null) use ($bourseItem): void
        {
            if(is_null($data)) return;

            if($data[2]){
                $amount = Utils::getItemAmount($player, $bourseItem->getItem());
                $player->getInventory()->removeItem($bourseItem->getItem()->setCount(Utils::getItemAmount($player, $bourseItem->getItem())));
            } else {
                if(!is_numeric($data[1])){
                    $player->sendMessage(Bourse::getInstance()->getConfig()->get("message")["not_numeric"]);
                    return;
                }

                $amount = intval($data[1]);
                $player->getInventory()->removeItem($bourseItem->getItem()->setCount($data[1]));
            }

            if($amount <= 0){
                $player->sendMessage(Bourse::getInstance()->getConfig()->get("message")["no_sell"]);
                return;
            }

            $total = $amount * $bourseItem->getActual();
            Bourse::getInstance()->economy->giveMoney($player, $total);
            $player->sendMessage(str_replace(
                ["{count}", "{item}", "{amount}"],
                [$amount, $bourseItem->getDisplayName(), $total],
                Bourse::getInstance()->getConfig()->get("message")["sell"]
            ));

        });
        $form->setTitle("Bourse > " . $bourseItem->getDisplayName());
        $form->addLabel("Prix min : $" . $bourseItem->getMin() . "\nPrix max : $" . $bourseItem->getMax() . "\n\nPrix actuel : $" . $bourseItem->getActual());
        $form->addInput("Combien veux-tu en vendre :", "Max : " . Utils::getItemAmount($player, $bourseItem->getItem()));
        $form->addToggle("Tout vendre ?");
        $player->sendForm($form);
    }
}