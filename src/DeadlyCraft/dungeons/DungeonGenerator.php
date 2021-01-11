<?php

namespace DeadlyCraft\dungeons;

class DungennGenerator {

    public static $dungeonId = -1;
    
    public function __construct(Dungeon $dungeon) {
        $this->dungeon = $dungeon;
        $this->stage = $dungeon->getStage();
        $this->channel = new $dungeon->getChannelClass()(self::nextDungeonId(), $this->stage->getWorld(), $dungeon);
    }

    public function makeDungeon() {

    }

    private static function nextDungeonId() :string{
        self::$dungeonId++;
        return "Doungeon".self::$dungeonId;
    }
}