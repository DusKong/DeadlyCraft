<?php

namespace DeadlyCraft\entity;

use minecraft\Channel;

class DamageDisplayEntity extends Entity{

    const DISPLAY_TIME = 1.5 * 20;

    public function __construct(Channel $channel, int $damage) {
        parent::__construct($channel);
    }
}