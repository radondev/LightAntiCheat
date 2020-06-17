<?php

declare(strict_types=1);

namespace radondev\lac\tasks;

use pocketmine\scheduler\Task;
use pocketmine\Server;
use radondev\lac\Loader;
use radondev\lac\threading\player\PlayerViolationPacket;

class PunishmentTask extends Task
{
    /**
     * @var Server
     */
    private $server;
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
        $this->server = Loader::getInstance()->getServer();
        $this->punishmentTask = Loader::getInstance()->getPunishmentTask();
    }

    /**
     * @param int $currentTick
     */
    public function onRun(int $currentTick): void
    {
        foreach ($this->players as $packet) {
            $player = $this->server->getPlayerByRawUUID($packet->getRawUUID());

            // TODO punishments from config
        }
    }

    /**
     * @param PlayerViolationPacket $packet
     */
    public function add(PlayerViolationPacket $packet): void
    {
        $this->players[$packet->getId()] = $packet; // TODO string is not a valid key :shrug:

        //  {
        //    "player" => {
        //      0 =>
        //    }
        //  }
    }
}