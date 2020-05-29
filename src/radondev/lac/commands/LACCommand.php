<?php

declare(strict_types=1);

namespace radondev\lac\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginIdentifiableCommand;
use pocketmine\plugin\Plugin;
use radondev\lac\Loader;
use radondev\lac\utils\MessageBuilder;

class LACCommand extends Command implements PluginIdentifiableCommand
{
    /**
     * @var string
     */
    private $plainAuthors;
    /**
     * @var string
     */
    private $version;

    /**
     * LACCommand constructor.
     * @param string[] $authors
     * @param string $version
     */
    public function __construct(array $authors, string $version)
    {
        $this->plainAuthors = implode(", ", $authors);
        $this->version = $version;

        parent::__construct("lightanticheat", "LightAntiCheat command", "/lightanticheat", ["lac"]);
    }


    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param array $args
     * @return bool
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args): bool
    {
        $sender->sendMessage(
            MessageBuilder::info("LightAntiCheat v%s made by %s", [
                $this->version,
                $this->plainAuthors
            ])
        );
        return true;
    }

    /**
     * @return Plugin
     */
    public function getPlugin(): Plugin
    {
        return Loader::getInstance();
    }
}