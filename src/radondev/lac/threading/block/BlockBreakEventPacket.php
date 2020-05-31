<?php

declare(strict_types=1);

namespace radondev\lac\threading\block;

use pocketmine\math\Vector3;
use radondev\lac\threading\BlockExchangePacket;
use radondev\lac\threading\Info;

class BlockBreakEventPacket extends BlockExchangePacket
{
    /**
     * BlockBreakEventPacket constructor.
     * @param Vector3 $position
     * @param int $blockId
     */
    public function __construct(Vector3 $position, int $blockId)
    {
        parent::__construct(Info::BLOCK_BREAK_EVENT_PACKET, $position, $blockId);
    }
}