<?php

namespace DeadlyCraft\doungeons;

class TestDungeon extends Dungeon{

    public function getTopFloor() :int{
        return 5;
    }

    public function getFloorPatterns() :array{
        return [
            new FloorPattern(
                [
                    new BattleFloor(),
                    new BattleFloor(),
                    new BattleFloor(),
                    new BattleFloor(),
                    new BattleFloor(),
                    new BattleFloor(),
                    new BattleFloor(),
                    new BattleFloor(),
                    [ new BattleFloor(), new BattleFloor() ],
                    new BattleFloor(),
                    new BattleFloor(),
                    new BattleFloor(),
                    new BattleFloor(),
                    new BattleFloor(),
                    new BattleFloor(),
                    new BattleFloor(),
                    new BattleFloor(),
                ]
            )
        ];
    }

    public function getEntitySpawnRules() :array{
        return [
            [
                "identifier" => Zombie::class,
                "floor" => [ 1, 3 ],
                "weight" => 1,
            ]
        ]
    }
}