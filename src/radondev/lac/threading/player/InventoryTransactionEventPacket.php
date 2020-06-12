<?php

declare(strict_types=1);

namespace radondev\lac\threading\player;

use pocketmine\inventory\transaction\action\InventoryAction;
use radondev\lac\threading\Info;
use radondev\lac\threading\PlayerExchangePacket;

class InventoryTransactionEventPacket extends PlayerExchangePacket
{
    /**
     * @var InventoryAction[]
     */
    private $actions;

    /**
     * InventoryTransactionEventPacket constructor.
     * @param string $rawUuid
     * @param array $actions
     */
    public function __construct(string $rawUuid, array $actions)
    {
        $this->actions = $actions;

        parent::__construct(Info::INVENTORY_TRANSACTION_EVENT_PACKET, $rawUuid);
    }

    /**
     * @return InventoryAction[]
     */
    public function getActions(): array
    {
        return $this->actions;
    }

    /**
     * @param InventoryAction[] $actions
     */
    public function setActions(array $actions): void
    {
        $this->actions = $actions;
    }
}