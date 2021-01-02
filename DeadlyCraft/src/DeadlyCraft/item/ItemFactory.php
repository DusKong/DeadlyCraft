<?php

namespace DeadlyCraft\item;

use pocketmine\item\ItemIdentifier;
use pocketmine\item\ToolTier;
use minecraft\item\ItemFactory as Factory;

use DeadlyCraft\item\weapon\{
    DebugSword,
};

class ItemFactory{

    public function __construct() {
        $factory = Factory::getInstance();

        $factory->register(new DebugSword(new ItemIdentifier(ItemIds::DEBUG_SWORD, 0), "DebugSword", ToolTier::WOOD()));
    }
}