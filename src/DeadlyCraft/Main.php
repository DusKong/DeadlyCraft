<?php

namespace DeadlyCraft;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;
use minecraft\Minecraft;

use DeadlyCraft\channel\LobbyChannel;
use DeadlyCraft\player\PlayerSession;
use DeadlyCraft\item\ItemFactory;
use DeadlyCraft\utils\LootTable;

class Main extends PluginBase{
    use SingletonTrait;

    public static $DB;
    public static $lobbyChannel;

    public function onLoad() : void{
        self::setInstance($this);
    }

    public function onEnable() {
        self::$dataFolder = $this->getServer()->getDataPath();
        $this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);
        self::$lobbyChannel = new LobbyChannel("lobby", $this->getServer()->getWorldManager()->getDefaultWorld());
        Minecraft::getInstance()->addChannel(self::$lobbyChannel);
        Minecraft::getInstance()->setPlayerClass(PlayerSession::class);

        self::$DB = new DB(self::$dataFolder."database/playerdata");
        //self::$DB->query("CREATE TABLE IF NOT EXISTS account (name TEXT PRIMARY KEY, data TEXT)");
        //self::$DB->query("CREATE TABLE IF NOT EXISTS inventory (name TEXT PRIMARY KEY, data TEXT)");
        //self::$DB->query("CREATE TABLE IF NOT EXISTS config (name TEXT PRIMARY KEY, data TEXT)");
        //self::$DB->query("CREATE TABLE IF NOT EXISTS season (name TEXT PRIMARY KEY, data TEXT)");

        new ItemFactory();
        LootTable::init();
    }
}