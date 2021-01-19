<?php

namespace DeadlyCraft\utils;

use pocketmine\network\mcpe\convert\SkinAdapter;
use pocketmine\network\mcpe\convert\LegacySkinAdapter;
use DeadlyCraft\player\CustumeSkin;

class CustumeSkinAdapter implements SkinAdapter{

    public function toSkinData(CustumeSkin $skin) : SkinData{
        $pieces = $skin->getPieces();
        return new SkinData(
            $skin->getSkinId(),
            "geometry.humanoid.custom",
            $skin->getSkinImage(),
            [],
            $skin->getCape()->getImage(),
            $skin->getGeometryData(),
            "",
            true,
            true,
            true,
            $skin->getCape()->getId(),
            null,
            "wide",
            "#0",
            $pieces["skin"],
            $pieces["colors"],
        );
    }

    public function fromSkinData(SkinData $data) : Skin{
        $adapter = new LegacySkinAdapter();
        return $adapter->fromSkinData($data);
    }
}