<?php

namespace DeadlyCraft\item;

use pocketmine\item\{
    ItemIdentifier,
    ToolTier,
    ItemFactory as Factory,
    ArmorTypeInfo,
};

use DeadlyCraft\item\weapon\{
    DebugSword,
};

use DeadlyCraft\item\food\{
    DebugFood,
};

use DeadlyCraft\item\armor\{
    DebugHelmet,
};

use pocketmine\inventory\ArmorInventory;

class ItemFactory{

    public function __construct() {
        $factory = Factory::getInstance();

        $factory->registerCustomItem(new DebugHelmet(new ItemIdentifier(ItemIds::DEBUG_HELMET, 0), "pocketmine:debug_helmet", new ArmorTypeInfo(1, 196, ArmorInventory::SLOT_HEAD)));
        $factory->registerCustomItem(new DebugFood(new ItemIdentifier(ItemIds::DEBUG_FOOD, 0), "pocketmine:debug_food"));
        $factory->registerCustomItem(new DebugSword(new ItemIdentifier(ItemIds::DEBUG_SWORD, 0), "pocketmine:debug_sword", ToolTier::WOOD()));
    }
}