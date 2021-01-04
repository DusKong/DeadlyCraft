<?php

namespace DeadlyCraft\dungeons\stage;

use pocketmine\math\AxisAlignedBB;
use pocketmine\math\Vector3;

class TestStage extends Stage{

    public function getBranch() {
        return [
            new AxisAlignedBB(),
            new AxisAlignedBB(),
            new AxisAlignedBB(),
        ];
    }

    public function getBarrierPosition() :array{
        return [
            [
                new Vector3(),
            ],
            [
                new Vector3(),
            ],
            [
                new Vector3(),
            ]
        ]
    }

    public function getCrystalPosition() :Vector3{
        return new Vector3();
    }

    public function getSpawnPosition() :Vector3{
        return new Vector3();
    }
}