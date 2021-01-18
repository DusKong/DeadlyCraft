<?php

namespace DeadlyCraft\item\weapon;

use pocketmine\item\Sword;
use pocketmine\item\Releasable;
use minecraft\item\ItemComponentHandlingTrait;
use minecraft\item\components\{
    HandEquipped,
    MaxStackSize,
    Damage,
    UseAnimation,
    Icon,
    UseDuration,
    Shooter,
};

class DebugSword extends Sword{
    use ItemComponentHandlingTrait;

    public function getItemComponents() :array{
        return [
            new HandEquipped(true),
            new MaxStackSize(1),
            new Icon("sword", 0),
            new Damage(100),
            new UseAnimation("crossbow"),
            new UseDuration(72000),
            new Shooter([], 1.0, true),
        ];
    }
}