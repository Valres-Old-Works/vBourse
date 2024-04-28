<?php

namespace Valres\Bourse\forms;

use Atom\libs\jojoe77777\FormAPI\SimpleForm;
use pocketmine\player\Player;
use Valres\Bourse\Bourse;

class BourseForm
{
    public static function sendForm(Player $player): void
    {
        $bourseManager = Bourse::getInstance()->bourseManager;
        $form = new SimpleForm(function(Player $player, int $data = null) use ($bourseManager): void
        {
            if(is_null($data)) return;
            $bourseItem = $bourseManager->getAllBourse()[$data - 1];
            SellForm::sendForm($player, $bourseItem);
        });
        $form->setTitle("Bourse");
        foreach($bourseManager->getAllBourse() as $bourseItem){
            $form->addButton($bourseItem->getDisplayName() . "\n$" . $bourseItem->getActual(), 0, $bourseItem->getImageTexture());
        }
        $player->sendForm($form);

    }
}
