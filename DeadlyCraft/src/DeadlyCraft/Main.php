<?php

namespace DeadlyCraft;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;
use minecraft\Minecraft;

use DeadlyCraft\channel\LobbyChannel;
use DeadlyCraft\player\PlayerSession;

class Main extends PluginBase{
    use SingletonTrait;

    public function __construct() {
        self::setInstance($this);
    }

    public function onEnable() {
        $this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);
        self::$lobbyChannel = new LobbyChannel($this->getServer()->getDefaultLevel(), "lobby");
        Minecraft::getInstance()->addChannel(self::$lobbyChannel);
        Minecraft::getInstance()->setPlayerClass(PlayerSession::class);
    }
}