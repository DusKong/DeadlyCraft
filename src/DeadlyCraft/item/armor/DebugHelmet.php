<?php

namespace DeadlyCraft\item\armor;

use pocketmine\item\Armor;
use minecraft\item\ItemComponentHandlingTrait;
use minecraft\item\components\Wearable;
use minecraft\item\components\MaxStackSize;
use minecraft\item\components\Durability;
use minecraft\item\components\Icon;
use minecraft\item\components\Foil;

class DebugHelmet extends Armor{
    use ItemComponentHandlingTrait;

    public function getItemComponents() :array{
        return [
            new MaxStackSize(1),
            new Icon("helmet", 4),
            new Wearable("slot.armor.head", 10),
            new Durability(0, 100),
            new Foil(true)
        ];
    }
}