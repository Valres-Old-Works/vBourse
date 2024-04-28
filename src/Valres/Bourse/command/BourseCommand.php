<?php

namespace Valres\Bourse\command;

use Atom\libs\CortexPE\Commando\BaseCommand;
use pocketmine\command\CommandSender;
use pocketmine\permission\DefaultPermissions;
use Valres\Bourse\command\subcommand\EditBourseCommand;

class BourseCommand extends BaseCommand
{
    protected function prepare(): void
    {
        $this->setPermission(DefaultPermissions::ROOT_USER);
        $this->registerSubCommand(new EditBourseCommand("edit", "Modifier la bourse"));
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {

    }

    public function getPermission() {}
}
