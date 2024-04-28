<?php

namespace Valres\Bourse;

use JsonException;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;
use Valres\Bourse\command\BourseCommand;
use Valres\Bourse\libs\DaPigGuy\libPiggyEconomy\exceptions\MissingProviderDependencyException;
use Valres\Bourse\libs\DaPigGuy\libPiggyEconomy\exceptions\UnknownProviderException;
use Valres\Bourse\libs\DaPigGuy\libPiggyEconomy\libPiggyEconomy;
use Valres\Bourse\libs\DaPigGuy\libPiggyEconomy\providers\EconomyProvider;
use Valres\Bourse\manager\BourseManager;

class Bourse extends PluginBase
{
    public EconomyProvider $economy;
    public BourseManager $bourseManager;
    use SingletonTrait;

    /**
     * @throws UnknownProviderException
     * @throws MissingProviderDependencyException
     */
    protected function onEnable(): void
    {
        $this->saveDefaultConfig();
        $this->getLogger()->info("by Valres est lancé !");
        libPiggyEconomy::init();
        $this->economy = libPiggyEconomy::getProvider($this->getConfig()->get("economy"));
        $this->bourseManager = new BourseManager();
        $this->bourseManager->loadBourse();

        $this->getServer()->getCommandMap()->register("bourse", new BourseCommand($this, "bourse", "Ouvre l'interface de la bourse."));
    }

    protected function onLoad(): void
    {
        self::setInstance($this);
    }

    /**
     * @return void
     * @throws JsonException
     */
    protected function onDisable(): void
    {
        $this->bourseManager->saveBourse();
    }
}
