<?php

declare(strict_types=1);

namespace radondev\lac\threading\player;

use radondev\lac\threading\Info;
use radondev\lac\threading\PlayerExchangePacket;

class PlayerViolationPacket extends PlayerExchangePacket
{
    // TODO Add violation object; will be implemented in v0.3

    /**
     * PlayerViolationPacket constructor.
     * @param string $rawUuid
     */
    public function __construct(string $rawUuid)
    {
        parent::__construct(Info::PLAYER_VIOLATION_PACKET, $rawUuid);
    }
}