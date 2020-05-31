<?php

declare(strict_types=1);

namespace radondev\lac\threading\player;

use radondev\lac\threading\Info;
use radondev\lac\threading\PlayerExchangePacket;

class PlayerEffectAddEventPacket extends PlayerExchangePacket
{
    /**
     * @var int $effectId
     */
    private $effectId;
    /**
     * @var int $effectLevel
     */
    private $effectLevel;

    /**
     * PlayerEffectAddEventPacket constructor.
     * @param string $rawUuid
     * @param int $effectId
     * @param int $effectLevel
     */
    public function __construct(string $rawUuid, int $effectId, int $effectLevel)
    {
        $this->effectId = $effectId;
        $this->effectLevel = $effectLevel;

        parent::__construct(Info::PLAYER_EFFECT_ADD_PACKET, $rawUuid);
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

    /**
     * @return int
     */
    public function getEffectLevel(): int
    {
        return $this->effectLevel;
    }

    /**
     * @param int $effectLevel
     */
    public function setEffectLevel(int $effectLevel): void
    {
        $this->effectLevel = $effectLevel;
    }
}