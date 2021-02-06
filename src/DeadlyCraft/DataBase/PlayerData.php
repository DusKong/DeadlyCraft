<?php

namespace DeadlyCraft\DataBase;

use DeadlyCraft\Main;

abstract class PlayerData extends Data{

    protected $name;

    public function __construct(string $name) {
        $this->name = $name;
    }

    public function checkData() :bool{
        $c = Main::$DB->num_rows("SELECT name FROM ".$this->tableName." WHERE name = '".$this->name."'") != 0;
        if($c) {
            $this->syncData();
            return true;
        }else{
            $this->saveToData();
            return false;
        }
    }

    public function syncData() :void{
        $result = Main::$DB->get_row("SELECT * FROM ".$this->tableName." WHERE name = '" . $this->name . "'");
        $legacyData = $this->jsonDeserialize(json_decode($result["data"], true));
        foreach ($legacyData as $dataName => $data) {
            $this->status[$dataName] = $data;
        }
    }

    public function saveToData() :void{
        $c = Main::$DB->num_rows("SELECT name FROM ".$this->tableName." WHERE name = '".$this->name."'") != 0;
        if($c) {
            Main::$DB->update($this->tableName, ["data" => json_encode($this->jsonSerialize())], ["name" => $this->name]);
        }else{
            Main::$DB->insert($this->tableName, ["name" => $this->name, "data" => json_encode($this->jsonSerialize())]);
        }
    }

    public function jsonSerialize() :array{
        return $this->status;
    }

    public function jsonDeserialize(array $status) :array{
        return $status;
    }
}