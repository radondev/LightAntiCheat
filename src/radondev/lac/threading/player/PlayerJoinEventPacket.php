<?php

declare(strict_types=1);

namespace radondev\lac\threading\player;

use radondev\lac\threading\Info;
use radondev\lac\threading\PlayerExchangePacket;

class PlayerJoinEventPacket extends PlayerExchangePacket
{
    /**
     * @var string $ip
     */
    private $ip;
    /**
     * @var int $deviceOS
     */
    private $deviceOS;

    /**
     * PlayerJoinEventPacket constructor.
     * @param string $rawUuid
     * @param string $ip
     * @param int $deviceOS
     */
    public function __construct(string $rawUuid, string $ip, int $deviceOS)
    {
        $this->ip = $ip;
        $this->deviceOS = $deviceOS;

        parent::__construct(Info::PLAYER_JOIN_EVENT_PACKET, $rawUuid);
    }

    /**
     * @return string
     */
    public function getIp(): string
    {
        return $this->ip;
    }

    /**
     * @param string $ip
     */
    public function setIp(string $ip): void
    {
        $this->ip = $ip;
    }

    /**
     * @return int
     */
    public function getDeviceOS(): int
    {
        return $this->deviceOS;
    }

    /**
     * @param int $deviceOS
     */
    public function setDeviceOS(int $deviceOS): void
    {
        $this->deviceOS = $deviceOS;
    }
}