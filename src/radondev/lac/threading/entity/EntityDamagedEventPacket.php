<?php

declare(strict_types=1);

namespace radondev\lac\threading\entity;

use pocketmine\math\Vector3;
use radondev\lac\threading\EntityExchangePacket;
use radondev\lac\threading\Info;

class EntityDamagedEventPacket extends EntityExchangePacket
{
    /**
     * @var Vector3 $position
     */
    private $position;
    /**
     * @var int $cause
     */
    private $cause;

    /**
     * EntityDamagedEventPacket constructor.
     * @param int $entityId
     * @param Vector3 $position
     * @param int $cause
     */
    public function __construct(int $entityId, Vector3 $position, int $cause)
    {
        $this->position = $position;
        $this->cause = $cause;

        parent::__construct(Info::ENTITY_DAMAGED_EVENT_PACKET, $entityId);
    }

    /**
     * @return Vector3
     */
    public function getPosition(): Vector3
    {
        return $this->position;
    }

    /**
     * @param Vector3 $position
     */
    public function setPosition(Vector3 $position): void
    {
        $this->position = $position;
    }

    /**
     * @return int
     */
    public function getCause(): int
    {
        return $this->cause;
    }

    /**
     * @param int $cause
     */
    public function setCause(int $cause): void
    {
        $this->cause = $cause;
    }
}