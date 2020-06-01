<?php

declare(strict_types=1);

namespace radondev\lac\threading\player;

use radondev\lac\threading\Info;
use radondev\lac\threading\PlayerExchangePacket;

class PlayerEffectRemoveEventPacket extends PlayerExchangePacket
{
    /**
     * @var int $effectId
     */
    private $effectId;

    /**
     * PlayerEffectRemoveEventPacket constructor.
     * @param string $rawUuid
     * @param int $effectId
     */
    public function __construct(string $rawUuid, int $effectId)
    {
        $this->effectId = $effectId;

        parent::__construct(Info::PLAYER_EFFECT_REMOVE_PACKET, $rawUuid);
    }

    /**
     * @return int
     */
    public function getEffectId(): int
    {
        return $this->effectId;
    }

    /**
     * @param int $effectId
     */
    public function setEffectId(int $effectId): void
    {
        $this->effectId = $effectId;
    }
}