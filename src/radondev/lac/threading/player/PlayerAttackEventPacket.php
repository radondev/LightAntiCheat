<?php

declare(strict_types=1);

namespace radondev\lac\threading\entity;

use pocketmine\math\Vector3;
use radondev\lac\threading\Info;
use radondev\lac\threading\PlayerExchangePacket;

class PlayerAttackEventPacket extends PlayerExchangePacket
{
    /**
     * @var Vector3 $positionAttacker
     */
    private $positionAttacker;
    /**
     * @var Vector3 $positionEntity
     */
    private $positionEntity;
    /**
     * @var int $cause
     */
    private $cause;
    /**
     * @var float
     */
    private $knockBack;
    /**
     * @var float
     */
    private $yaw;
    /**
     * @var float
     */
    private $pitch;

    /**
     * PlayerAttackEventPacket constructor.
     * @param string $rawUuid
     * @param Vector3 $positionAttacker
     * @param Vector3 $positionEntity
     * @param int $cause
     * @param float $knockBack
     * @param float $yaw
     * @param float $pitch
     */
    public function __construct(string $rawUuid, Vector3 $positionAttacker, Vector3 $positionEntity, int $cause, float $knockBack, float $yaw, float $pitch)
    {
        $this->positionAttacker = $positionAttacker;
        $this->positionEntity = $positionEntity;
        $this->cause = $cause;
        $this->knockBack = $knockBack;
        $this->yaw = $yaw;
        $this->pitch = $pitch;

        parent::__construct(Info::PLAYER_ATTACK_EVENT_PACKET, $rawUuid);
    }

    /**
     * @return Vector3
     */
    public function getPositionAttacker(): Vector3
    {
        return $this->positionAttacker;
    }

    /**
     * @param Vector3 $positionAttacker
     */
    public function setPositionAttacker(Vector3 $positionAttacker): void
    {
        $this->positionAttacker = $positionAttacker;
    }

    /**
     * @return Vector3
     */
    public function getPositionEntity(): Vector3
    {
        return $this->positionEntity;
    }

    /**
     * @param Vector3 $positionEntity
     */
    public function setPositionEntity(Vector3 $positionEntity): void
    {
        $this->positionEntity = $positionEntity;
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

    /**
     * @return float
     */
    public function getKnockBack(): float
    {
        return $this->knockBack;
    }

    /**
     * @param float $knockBack
     */
    public function setKnockBack(float $knockBack): void
    {
        $this->knockBack = $knockBack;
    }

    /**
     * @return float
     */
    public function getYaw(): float
    {
        return $this->yaw;
    }

    /**
     * @param float $yaw
     */
    public function setYaw(float $yaw): void
    {
        $this->yaw = $yaw;
    }

    /**
     * @return float
     */
    public function getPitch(): float
    {
        return $this->pitch;
    }

    /**
     * @param float $pitch
     */
    public function setPitch(float $pitch): void
    {
        $this->pitch = $pitch;
    }
}