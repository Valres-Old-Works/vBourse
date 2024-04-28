<?php

namespace Valres\Bourse\command;

use pocketmine\command\CommandSender;
use pocketmine\permission\DefaultPermissions;
use pocketmine\player\Player;
use Valres\Bourse\command\subcommand\EditBourseCommand;
use Valres\Bourse\forms\BourseForm;
use Valres\Bourse\libs\CortexPE\Commando\BaseCommand;

class BourseCommand extends BaseCommand
{
    protected function prepare(): void
    {
        $this->setPermission(DefaultPermissions::ROOT_USER);
        $this->registerSubCommand(new EditBourseCommand("edit", "Modifier la bourse"));
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        if(!$sender instanceof Player) return;
        BourseForm::sendForm($sender);
    }

    public function getPermission() {}
}
