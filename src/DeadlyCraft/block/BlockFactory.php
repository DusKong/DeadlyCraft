<?php

namespace DeadlyCraft\block;

use pocketmine\block\BlockIdentifier as BID;
use pocketmine\block\BlockFactory as Factory;
use pocketmine\block\BlockBreakInfo;

class BlockFactory {

    public function __construct() {
        $factory = Factory::getInstance();
        $breakInfo = new BlockBreakInfo(2.5);

        $factory->registerCustomBlock(new BarrierPortalBlock(new BID(BlockIds::BARRIER_PORTAL_BLOCK), "pocketmine:barrier_portal_block", $breakInfo));
    }
}