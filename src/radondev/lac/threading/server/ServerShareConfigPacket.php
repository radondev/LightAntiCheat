<?php

declare(strict_types=1);

namespace radondev\lac\threading\server;

use radondev\lac\threading\ExchangePacket;
use radondev\lac\threading\Info;

class ServerShareConfigPacket extends ExchangePacket
{
    /**
     * @var array
     */
    private $rawConfig;

    /**
     * ServerShareConfigPacket constructor.
     * @param array $rawConfig
     */
    public function __construct(array $rawConfig)
    {
        $this->rawConfig = $rawConfig;

        parent::__construct(Info::SERVER_SHARE_CONFIG_PACKET);
    }

    /**
     * @return array
     */
    public function getRawConfig(): array
    {
        return $this->rawConfig;
    }

    /**
     * @param array $rawConfig
     */
    public function setRawConfig(array $rawConfig): void
    {
        $this->rawConfig = $rawConfig;
    }
}