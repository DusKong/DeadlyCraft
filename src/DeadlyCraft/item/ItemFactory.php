<?php

namespace DeadlyCraft\item;

use pocketmine\item\ItemIdentifier;
use pocketmine\item\ToolTier;
use pocketmine\item\ItemFactory as Factory;

use DeadlyCraft\item\weapon\{
    DebugSword,
};

use DeadlyCraft\item\food\{
    DebugFood,
};

class ItemFactory{

    public function __construct() {
        $factory = Factory::getInstance();

        $factory->registerCustomItem(new DebugSword(new ItemIdentifier(ItemIds::DEBUG_SWORD, 0), "DebugSword", ToolTier::WOOD()));
        $factory->registerCustomItem(new DebugFood(new ItemIdentifier(ItemIds::DEBUG_FOOD, 0), "DebugFood"));
    }
}