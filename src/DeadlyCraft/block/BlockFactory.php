<?php

namespace DeadlyCraft\block;

use pocketmine\block\Block;
use pocketmine\block\BlockIdentifier as BID;
use pocketmine\block\BlockFactory as Factory;
use pocketmine\block\BlockBreakInfo;

class BlockFactory {

    public function __construct() {
        $factory = Factory::getInstance();
        $breakInfo = new BlockBreakInfo(2.5);

        $factory->registerCustomBlock(new Block(new BID(901, 0), "const:anvil_block", $breakInfo));
        $factory->registerCustomBlock(new BarrierPortalBlock(new BID(BlockIds::BARRIER_PORTAL_BLOCK, 0, BlockIds::BARRIER_PORTAL_BLOCK), "pocketmine:barrier_portal_block", $breakInfo));
    }
}