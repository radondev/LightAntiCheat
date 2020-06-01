<?php

declare(strict_types=1);

namespace radondev\lac\threading;

abstract class EntityExchangePacket extends ExchangePacket
{
    /**
     * @var int $entityId
     */
    private $entityId;

    /**
     * EntityExchangePacket constructor.
     * @param int $id
     * @param int $entityId
     */
    public function __construct(int $id, int $entityId)
    {
        $this->entityId = $entityId;

        parent::__construct($id);
    }

    /**
     * @return int
     */
    public function getEntityId(): int
    {
        return $this->entityId;
    }
}