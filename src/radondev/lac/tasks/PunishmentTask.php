<?php

declare(strict_types=1);

namespace radondev\lac\tasks;

use pocketmine\scheduler\Task;
use radondev\lac\Loader;
use radondev\lac\threading\player\PlayerViolationPacket;

class PunishmentTask extends Task
{
    /**
     * @var PunishmentTask
     */
    private $punishmentTask;

    /**
     * @var PlayerViolationPacket[]
     */
    private $players;

    /**
     * PunishmentTask constructor.
     */
    public function __construct()
    {
        $this->punishmentTask = Loader::getInstance()->getPunishmentTask();
    }

    /**
     * @param int $currentTick
     */
    public function onRun(int $currentTick): void
    {
        foreach ($this->players as $playerName => $packet) {
            // TODO punishments from config
        }
    }

    /**
     * @param string $name
     * @param PlayerViolationPacket $packet
     */
    public function add(string $name, PlayerViolationPacket $packet): void
    {
        $this->players[$name][$packet->getId()] = $packet;

        //  {
        //    "player" => {
        //      0 =>
        //    }
        //  }
    }
}