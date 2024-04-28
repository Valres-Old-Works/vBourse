<?php

namespace Valres\Bourse\command\subcommand;

use pocketmine\command\CommandSender;
use pocketmine\permission\DefaultPermissions;
use pocketmine\player\Player;
use Valres\Bourse\forms\EditBourseForm;
use Valres\Bourse\libs\CortexPE\Commando\BaseSubCommand;

class EditBourseCommand extends BaseSubCommand
{
    protected function prepare(): void
    {
        $this->setPermission(DefaultPermissions::ROOT_OPERATOR);
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        if(!$sender instanceof Player) return;
        EditBourseForm::sendForm($sender);
    }
}