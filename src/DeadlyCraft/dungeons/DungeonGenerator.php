<?php

namespace DeadlyCraft\dungeons;

class DungennGenerator {

    public static $dungeonId = -1;
    
    public function __construct(Dungeon $dungeon) {
        $this->dungeon = $dungeon;
        $this->stage = $dungeon->getStage();
        $this->channel = new DungeonChannel(self::nextDungeonId(), $this->stage->getWorld());
    }

    public function makeDungeon() {

    }

    public static function nextDungeonId() :string{
        self::$dungeonId++;
        return "Doungeon".self::$dungeonId;
    }
}