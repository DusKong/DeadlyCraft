<?php

namespace DeadlyCraft;

use pocketmine\plugin\PluginBase;
use pocketmine\entity\Location;
use pocketmine\network\mcpe\convert\SkinAdapterSingleton;
use pocketmine\utils\SingletonTrait;
use minecraft\Minecraft;

use DeadlyCraft\channel\LobbyChannel;
use DeadlyCraft\player\PlayerSession;
use DeadlyCraft\item\ItemFactory;
use DeadlyCraft\block\BlockFactory;
use DeadlyCraft\entity\EntityFactory;
use DeadlyCraft\utils\LootTable;
use DeadlyCraft\utils\CustumeSkinAdapter;
use DeadlyCraft\DataBase\DB;

use DeadlyCraft\commands\{
    BlockCommand,
    TestCommand,
};

class Main extends PluginBase{
    use SingletonTrait;

    public static $DB;
    public static $lobbyChannel;

    public static $dataFolder;

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
        self::$DB->query("CREATE TABLE IF NOT EXISTS account (name TEXT PRIMARY KEY, data TEXT)");
        self::$DB->query("CREATE TABLE IF NOT EXISTS status (name TEXT PRIMARY KEY, data TEXT)");
        //self::$DB->query("CREATE TABLE IF NOT EXISTS inventory (name TEXT PRIMARY KEY, data TEXT)");
        //self::$DB->query("CREATE TABLE IF NOT EXISTS config (name TEXT PRIMARY KEY, data TEXT)");
        //self::$DB->query("CREATE TABLE IF NOT EXISTS season (name TEXT PRIMARY KEY, data TEXT)");

        new ItemFactory();
        new BlockFactory();
        new EntityFactory();
        LootTable::init();
        //SkinAdapterSingleton::set(new CustumeSkinAdapter());

        $this->getServer()->getCommandMap()->register("pocketmine", new BlockCommand("block"));
        $this->getServer()->getCommandMap()->register("pocketmine", new TestCommand("test"));
    }

    public function getLobbyPosition() :Location{
        return new Location(0.5, 111, 0.5, 180, 0, $this->getServer()->getWorldManager()->getDefaultWorld());
    }
}