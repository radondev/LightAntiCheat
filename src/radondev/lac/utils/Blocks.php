<?php

declare(strict_types=1);

namespace radondev\lac\utils;

use pocketmine\block\Block;
use pocketmine\level\Level;
use pocketmine\level\Position;
use pocketmine\math\Vector3;

class Blocks
{
    /**
     * @param Level $level
     * @param Vector3 $position
     * @return Block
     */
    public static function getBlockBelow(Level $level, Vector3 $position): Block
    {
        return $level->getBlock(
            $position->subtract(0, 1, 0)
        );
    }

    /**
     * @param Position $position
     * @return Block[]
     */
    public static function getBlocksBelow(Position $position): array
    {
        // i wrote this code more than a year ago. it is probably not as good, as it could/should be

        $level = $position->getLevel();
        $blocks = array();
        $directions = array(
            "x1" => ($position->x > floor($position->x) + 0.5) ? 0 : 1,
            "x2" => ($position->x < floor($position->x) + 0.5) ? 1 : 2,
            "z1" => ($position->z > floor($position->z) + 0.5) ? 0 : 1,
            "z2" => ($position->z < floor($position->z) + 0.5) ? 1 : 2
        );

        for ($x = $position->x - $directions["x1"]; $x < $position->x + $directions["x2"]; $x++) {
            for ($z = $position->z - $directions["z1"]; $z < $position->z + $directions["z2"]; $z++) {
                $blocks[] = self::getBlockBelow($level, new Vector3($x, $position->getY(), $z));
            }
        }

        return $blocks;
    }
}