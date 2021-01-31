<?php

namespace DeadlyCraft\inventory;

use pocketmine\inventory\BaseInventory;

class SerializeInventory extends BaseInventory{

    public function __construct() {
        parent::__construct(36);
    }
}