<?php

namespace Valres\Bourse;

use DaPigGuy\libPiggyEconomy\exceptions\MissingProviderDependencyException;
use DaPigGuy\libPiggyEconomy\exceptions\UnknownProviderException;
use DaPigGuy\libPiggyEconomy\libPiggyEconomy;
use DaPigGuy\libPiggyEconomy\providers\EconomyProvider;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;
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
    }

    protected function onLoad(): void
    {
        self::setInstance($this);
    }

    protected function onDisable(): void
    {

    }
}
