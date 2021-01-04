<?php

namespace DeadlyCraft\item\food;

use pocketmine\item\Food;
use minecraft\item\FoodComponent;

class DebugFood extends Food{
    use FoodComponent;

    public function componentInit() :void{
        $this->identifier = "pocketmine:debug_food";
        $this->use_duration = 2;
        $this->use_animation = "eat";
        $this->nutrition = 4;
        $this->saturation_modifier = "low";
        $this->texture = "sword";
        $this->frame_index = 2;
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