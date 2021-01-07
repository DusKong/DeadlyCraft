<?php

namespace DeadlyCraft\item\weapon;

use pocketmine\item\Sword;
use minecraft\item\ItemComponentHandlingTrait;
use minecraft\item\components\HandEquipped;
use minecraft\item\components\MaxStackSize;
use minecraft\item\components\Icon;

class DebugSword extends Sword{
    use ItemComponentHandlingTrait;

    public function getIdentifier() :string{
        return "pocketmine:debug_sword";
    }

    public function getItemComponents() :array{
        return [
            new HandEquipped(true),
            new MaxStackSize(1),
            new Icon("sword", 0),
        ];
    }
}