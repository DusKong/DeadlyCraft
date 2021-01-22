<?php

namespace DeadlyCraft\doungeons;

class TestDungeon extends Dungeon{

    public function getTopFloor() :int{
        return 5;
    }

    public function getLayerPattern() :array{
        return [
            [
                new BattleLayer(),
                new BattleLayer(),
                new BattleLayer(),
                new BattleLayer(),
                new BattleLayer(),
                new BattleLayer(),
                new BattleLayer(),
                new BattleLayer(),
            ]
        ];
    }

    public function getEntitySpawnTable() :array{
        return [
            [
                "identifier" => Zombie::class,
                "conditions" => [
                    "floor"
                ],
                "floor" => [ 1, 3 ],
                "weight" => 1,
            ]
        ]
    }
}