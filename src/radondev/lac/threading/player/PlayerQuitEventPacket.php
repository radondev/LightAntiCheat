<?php

declare(strict_types=1);

namespace radondev\lac\threading\player;

use radondev\lac\threading\Info;
use radondev\lac\threading\PlayerExchangePacket;

class PlayerQuitEventPacket extends PlayerExchangePacket
{
    /**
     * PlayerQuitEventPacket constructor.
     * @param string $rawUuid
     */
    public function __construct(string $rawUuid)
    {
        parent::__construct(Info::PLAYER_QUIT_EVENT_PACKET, $rawUuid);
    }
}