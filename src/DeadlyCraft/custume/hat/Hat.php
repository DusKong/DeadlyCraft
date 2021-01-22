<?php

namespace DeadlyCraft\custume\hat;

use DeadlyCraft\custume\Persona;

abstract class Hat extends Persona{

    public function getPieceType() :string{
        return "persona_head";
    }
}