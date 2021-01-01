<?php

namespace DeadlyCraft\channel;

use minecraft\Channel as APIChanel;

class Channel extends APIChanel{

    public function joinChannel(Player $player) :void{
        parent::joinChannel($player);
    }
}