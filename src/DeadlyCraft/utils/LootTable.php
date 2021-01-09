<?php

namespace DeadlyCraft\utils;

use pocketmine\Server;
use pocketmine\item\ItemFactory;

class LootTable {

    private static $loots = [];

    public static function init() {
        $fullPath = Server::getInstance()->getPluginPath()."resources\\loot_tables\\";
        $files = glob($fullPath.'{*.json}',GLOB_BRACE);
        foreach ($files as $file) {
            $fileName = basename($file);
            self::$loots[$fileName] = new LootTable($file);
        }
    }

    public static function get(string $loot) {
        if(!isset(self::$loots[$loot])) {
            return self::$loots["empty.json"];
        }
        return self::$loots[$loot];
    }

    public function __construct(string $lootFile) {
        $this->lootFile = json_decode(file_get_contents($lootFile), true);
    }

    public function getRandomLoot(Player $player) :void{
        $text = "";
        if(!isset($this->lootFile["pools"])) return;
        foreach ($this->lootFile["pools"] as $pool) {
            $weight = [];
            foreach ($pool["entries"] as $key => $entry) {
                for ($i=0; $i < $entry["weight"]; $i++) { 
                    $weight[] = $key;
                }
            }
            shuffle($weight);
            $rolls = $pool["rolls"];
            if(is_array($rolls)) $rolls = mt_rand($rolls["min"], $rools["max"]);
            for ($c=0; $c < $rolls; $c++) { 
                $key = $weight[array_rand($weight, 1)];

                $entry = $pool["entries"][$key];
                $type = $entry["type"];
                $count = $entry["count"];
                if(is_array($count)) $count = mt_rand($count["min"], $count["max"]);
                switch($type) {
                    case "item":
                        $item = ItemFactory::fromString($entry["name"]);
                        $item->setCount($count);
                        $player->addItem($item);
                        $text .= "§a".$item->getCustomName()." x".$count."\n";
                        break;
                    case "coin":
                        $player->getPlayerData()->addCoin($count);
                        $text .= "§e+ ".$count." coin\n";
                        break;
                    case "medal":
                        $player->getPlayerData()->addMedal($count);
                        $text .= "§b+ ".$count." medal\n";
                        break;
                }
            }
        }
        $player->sendTip($text);
    }
}