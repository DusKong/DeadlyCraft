<?php

namespace DeadlyCraft\item\armor;

use pocketmine\item\Armor;
use minecraft\item\ItemComponentHandlingTrait;
use minecraft\item\components\Wearable;
use minecraft\item\components\MaxStackSize;
use minecraft\item\components\Icon;
use minecraft\item\components\Foil;

class DebugHelmet extends Armor{
    use ItemComponentHandlingTrait;

    public function getIdentifier() :string{
        return "pocketmine:debug_helmet";
    }

    public function getItemComponents() :array{
        var_dump("aaaa");
        return [
            new MaxStackSize(1),
            new Icon("helmet", 1),
            new Wearable("slot.armor.head", 10),
            new Foil(true)
        ];
    }
}