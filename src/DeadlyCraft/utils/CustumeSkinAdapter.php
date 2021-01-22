<?php

namespace DeadlyCraft\utils;

use pocketmine\network\mcpe\convert\SkinAdapter;
use pocketmine\network\mcpe\convert\LegacySkinAdapter;
use pocketmine\network\mcpe\protocol\types\skin\SkinData;
use pocketmine\network\mcpe\protocol\types\skin\SkinImage;
use DeadlyCraft\player\CustumeSkin;

class CustumeSkinAdapter{

    public function toSkinData(CustumeSkin $skin) : SkinData{
        $pieces = $skin->getPieces();
        return new SkinData(
            $skin->getSkinId(),
            "geometry.humanoid.custom",
            SkinImage::fromLegacy($skin->getSkinData()),
            [],
            /*$skin->getCape()->getImage()*/new SkinImage(0, 0, ""),
            $skin->getGeometryData(),
            "",
            true,
            true,
            true,
            /*$skin->getCape()->getId()*/"",
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