<?php

namespace DeadlyCraft\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\defaults\VanillaCommand;
use pocketmine\Player;
use pocketmine\math\Vector3;

use pocketmine\block\BlockFactory;

class BlockCommand extends VanillaCommand {

    public function __construct(string $name){
        parent::__construct(
            $name,
            "/block",
            "/block"
        );
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        
        $blocks = BlockFactory::getInstance()->getAllKnownStates();
        $start = clone $sender->getPosition();
        $world = $sender->getWorld();
        $x = 0;
        $z = 0;
        foreach ($blocks as $block) {
            $posX = $start->x + $x;
            $posZ = $start->z + $z;
            $world->setBlock(new Vector3($posX, $start->y, $posZ), $block);
            $x++;
            if($x == 20) {
                $z++;
                $x = 0;
            }
        }
    }
}