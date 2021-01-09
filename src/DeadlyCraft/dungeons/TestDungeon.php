<?php

namespace DeadlyCraft\doungeons;

class TestDungeon extends Dungeon{

    public function getTopFloor() :int{
        return 5;
    }

    public function getEntitySpawnTable() :array{
        return [
            [
                "identifier" => Zombie::class,
                "floor" => [ 1, 3 ],
                "weight" => 1,
            ]
        ]
    }
}