<?php

namespace DeadlyCraft\item\food;

use pocketmine\item\Food;
use minecraft\item\ItemComponentHandlingTrait;
use minecraft\item\components\Food as MinecraftFood;
use minecraft\item\components\MaxStackSize;
use minecraft\item\components\Icon;
use minecraft\item\components\UseAnimation;

class DebugFood extends Food{
    use ItemComponentHandlingTrait;

    public function getItemComponents() :array{
        return [
            new Icon("helmet", 4),
            new MinecraftFood(true, 5, "low"),
            new UseAnimation("drink"),
        ];
    }

    public function requiresHunger() : bool{
        return false;
    }

    public function getFoodRestore() : int{
        return 4;
    }

    public function getSaturationRestore() : float{
        return 9.6;
    }
}