<?php

namespace Valres\Bourse\command\subcommand;

use Atom\libs\CortexPE\Commando\BaseSubCommand;
use pocketmine\command\CommandSender;
use pocketmine\permission\DefaultPermissions;

class EditBourseCommand extends BaseSubCommand
{

    protected function prepare(): void
    {
        $this->setPermission(DefaultPermissions::ROOT_OPERATOR);
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        // TODO: Implement onRun() method.
    }
}