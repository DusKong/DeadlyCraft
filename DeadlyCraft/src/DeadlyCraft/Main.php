<?php

namespace DeadlyCraft;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;
use minecraft\Minecraft;

use DeadlyCraft\channel\LobbyChannel;
use DeadlyCraft\player\PlayerSession;
use DeadlyCraft\item\ItemFactory;

class Main extends PluginBase{
    use SingletonTrait;

    public static $lobbyChannel;

    public function onLoad() : void{
        self::setInstance($this);
    }

    public function onEnable() {
        $this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);
        self::$lobbyChannel = new LobbyChannel("lobby", $this->getServer()->getWorldManager()->getDefaultWorld());
        Minecraft::getInstance()->addChannel(self::$lobbyChannel);
        Minecraft::getInstance()->setPlayerClass(PlayerSession::class);

        new ItemFactory();
    }
}