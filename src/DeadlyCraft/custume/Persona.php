<?php

namespace DeadlyCraft\custume;

abstract class Persona{

    public function getPieceId() :string{
        return "";
    }

    public function getPieceType() :string{
        return "";
    }

    public function getPackId() :string{
        return "";
    }

    public function getProductId() :string{
        return "";
    }

    public function getColors() :array{
        return [];
    }
}