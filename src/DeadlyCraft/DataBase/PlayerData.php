<?php

namespace DeadlyCraft\DataBase;

use pocketmine\player\Player;
use DeadlyCraft\Main;

abstract class PlayerData extends Data{

    public $player;

    public function __construct(Player $player) {
        $this->player = $player;
    }

    public function checkData() :bool{
        $c = Main::$DB->num_rows("SELECT name FROM ".$this->tableName." WHERE name = '".$this->player->getName()."'") != 0;
        if($c) {
            $this->syncData();
            return true;
        }else{
            $this->saveToData();
            return false;
        }
    }

    public function syncData() :void{
        $result = Main::$DB->get_row("SELECT * FROM ".$this->tableName." WHERE name = '" . $this->player->getName() . "'");
        $legacyData = json_decode($result["data"], true);
        foreach ($legacyData as $dataName => $data) {
            $this->status[$dataName] = $data;
        }
    }

    public function saveToData() :void{
        $c = Main::$DB->num_rows("SELECT name FROM ".$this->tableName." WHERE name = '".$this->player->getName()."'") != 0;
        if($c) {
            Main::$DB->update($this->tableName, ["data" => json_encode($this->status)], ["name" => $this->player->getName()]);
        }else{
            Main::$DB->insert($this->tableName, ["name" => $this->player->getName(), "data" => json_encode($this->status)]);
        }
    }
}