<?php

namespace DeadlyCraft\doungeons;

class TestDungeon extends Dungeon{

    public function getMaxFloor() :int{
        return 5;
    }

    public function getFloorRule() :array{
        return [
            [
                "identifier" => BattleFloor::class
            ]
        ]
    }

    public function getEntitySpawnRule() :array{
        return [
            [
                "identifier" => Zombie::class,
                "floor" => [ 1, 3 ],
                "weight" => 1,
            ]
        ]
    }
}