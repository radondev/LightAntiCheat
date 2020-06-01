<?php

declare(strict_types=1);

namespace radondev\lac\threading;

abstract class PlayerExchangePacket extends ExchangePacket
{
    /**
     * @var string
     */
    private $rawUuid;

    /**
     * PlayerExchangePacket constructor.
     * @param int $id
     * @param string $rawUuid
     */
    public function __construct(int $id, string $rawUuid)
    {
        $this->rawUuid = $rawUuid;

        parent::__construct($id);
    }

    /**
     * @return string
     */
    public function getRawUUID(): string
    {
        return $this->rawUuid;
    }
}