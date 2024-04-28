<?php

namespace Valres\Bourse\task;

use pocketmine\scheduler\Task;
use pocketmine\Server;
use Valres\Bourse\Bourse;

class ChangeBourseTask extends Task
{
    private string $hours;
    private string $minutes;

    public function __construct()
    {
        $config = Bourse::getInstance()->getConfig();
        $time = explode(":", $config->get("change-bourse-time"));
        $this->hours = $time[0];
        $this->minutes = $time[1];
    }

    public function onRun(): void
    {
        $time = explode(":", date("H:i:s"));
        if($time[0] === $this->hours and $time[1] === $this->minutes){
            foreach(Bourse::getInstance()->bourseManager->getAllBourse() as $bourseItem){
                $bourseItem->setActual(rand($bourseItem->getMin(), $bourseItem->getMax()));
            }
            Server::getInstance()->broadcastMessage(Bourse::getInstance()->getConfig()->get("message")["change_bourse"]);
        }
    }
}
