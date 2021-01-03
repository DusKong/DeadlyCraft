<?php

namespace DeadlyCraft\item\weapon;

use pocketmine\item\Sword;
use minecraft\item\ItemComponent;

class DebugSword extends Sword{
    use ItemComponent;

    public function componentInit() :void{//php 7.0.0前
        $this->identifier = "pocketmine:debug_sword";
        $this->hand_equipped = true;
        $this->max_stack_size = 1;
        $this->texture = "sword";
        $this->frame_index = 0;
    }
}