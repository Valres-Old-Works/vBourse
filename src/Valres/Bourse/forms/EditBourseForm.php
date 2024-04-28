<?php

namespace Valres\Bourse\forms;

use pocketmine\item\StringToItemParser;
use pocketmine\player\Player;
use Valres\Bourse\Bourse;
use Valres\Bourse\libs\jojoe77777\FormAPI\CustomForm;
use Valres\Bourse\libs\jojoe77777\FormAPI\SimpleForm;
use Valres\Bourse\manager\BourseItem;
use Valres\Bourse\utils\Utils;

class EditBourseForm
{
    public static function sendForm(Player $player): void
    {
        $form = new SimpleForm(function(Player $player, int $data = null): void
        {
            if(is_null($data)) return;

            switch($data){
                case 0:
                case 2:
                    self::sendEditForm($player, $data);
                    break;
                case 1:
                    self::sendAddItemForm($player, []);
                    break;
            }
        });
        $form->setTitle("Bourse > Edit");
        $form->addButton("Modifier un item");
        $form->addButton("Ajouter un item");
        $form->addButton("Retirer un item");
        $player->sendForm($form);
    }

    public static function sendEditForm(Player $player, int $previousData): void
    {
        $bourseManager = Bourse::getInstance()->bourseManager;
        $form = new SimpleForm(function(Player $player, int $data = null) use ($bourseManager, $previousData): void
        {
            if(is_null($data)) return;

            $bourseItem = $bourseManager->getAllBourse()[$data];

            switch($previousData){
                default:
                    self::sendEditItemForm($player, $bourseItem, []);
                    break;
                case 2:
                    $bourseManager->removeBourseItem($data);
                    $player->sendMessage(Bourse::getInstance()->getConfig()->get("message")["remove"]);
                    break;
            }
        });
        $form->setTitle("Bourse > Edit > " . ($previousData === 0 ? "Modifier" : "Supprimer"));
        foreach($bourseManager->getAllBourse() as $bourseItem){
            $form->addButton($bourseItem->getDisplayName(), 0, $bourseItem->getImageTexture());
        }
        $player->sendForm($form);
    }

    public static function sendEditItemForm(Player $player, BourseItem $bourseItem, array $missing): void
    {
        $form = new CustomForm(function(Player $player, array $data = null) use ($bourseItem): void
        {
            if(is_null($data)) return;

            match(true){
                $data[0] === "" => $missing[] = "name",
                $data[1] === "" => $missing[] = "image",
                $data[2] === "" => $missing[] = "min",
                $data[3] === "" => $missing[] = "max",
                $data[4] === "" => $missing[] = "actuel",
                default => $missing = []
            };

            if(!empty($missing)){
                self::sendEditItemForm($player, $bourseItem, $missing);
                return;
            }

            if($data[2] > $data[3]){
                $player->sendMessage(Bourse::getInstance()->getConfig()->get("message")["higher_error"]);
                return;
            }

            $bourseItem->setDisplayName($data[0]);
            $bourseItem->setImageTexture($data[1]);
            $bourseItem->setMin($data[2]);
            $bourseItem->setMax($data[3]);
            $bourseItem->setActual($data[4]);
            $player->sendMessage(Bourse::getInstance()->getConfig()->get("message")["edit"]);
            Bourse::getInstance()->bourseManager->saveBourse();
        });
        $form->setTitle("Bourse > Modifier > " . $bourseItem->getDisplayName());
        $form->addInput("Nom :" . (in_array("name", $missing) ? "\n§c*obligatoire" : ""), "", $bourseItem->getDisplayName());
        $form->addInput("Image de texture :" . (in_array("image", $missing) ? "\n§c*obligatoire" : ""), "", $bourseItem->getImageTexture());
        $form->addInput("Prix min :" . (in_array("min", $missing) ? "\n§c*obligatoire" : ""), "", $bourseItem->getMin());
        $form->addInput("Prix max :" . (in_array("max", $missing) ? "\n§c*obligatoire" : ""), "", $bourseItem->getMax());
        $form->addInput("Prix actuel : " . (in_array("actuel", $missing) ? "\n§c*obligatoire" : ""), "", $bourseItem->getActual());
        $player->sendForm($form);
    }

    public static function sendAddItemForm(Player $player, array $missing): void
    {
        $form = new CustomForm(function(Player $player, array $data = null): void
        {
            if(is_null($data)) return;

            match(true){
                $data[0] === "" => $missing[] = "item",
                $data[1] === "" => $missing[] = "name",
                $data[2] === "" => $missing[] = "image",
                $data[3] === "" => $missing[] = "min",
                $data[4] === "" => $missing[] = "max",
                default => $missing = []
            };

            if(!empty($missing)){
                self::sendAddItemForm($player, $missing);
                return;
            }

            if($data[3] > $data[4]){
                $player->sendMessage(Bourse::getInstance()->getConfig()->get("message")["higher_error"]);
                return;
            }

            Bourse::getInstance()->bourseManager->addBourseItem(StringToItemParser::getInstance()->parse(Utils::getAllItemInInvInString($player)[$data[0]]), $data[1], $data[2], $data[3], $data[4]);
            $player->sendMessage(Bourse::getInstance()->getConfig()->get("message")["add"]);
        });
        $form->setTitle("Bourse > Edit > Ajouter");
        $form->addDropdown("Item : " . (in_array("item", $missing) ? "\n§c*obligatoire" : ""), Utils::getAllItemInInvInString($player), 0);
        $form->addInput("Nom :" . (in_array("name", $missing) ? "\n§c*obligatoire" : ""));
        $form->addInput("Image de texture :" . (in_array("image", $missing) ? "\n§c*obligatoire" : ""));
        $form->addInput("Prix min :" . (in_array("min", $missing) ? "\n§c*obligatoire" : ""));
        $form->addInput("Prix max :" . (in_array("max", $missing) ? "\n§c*obligatoire" : ""));
        $player->sendForm($form);
    }
}