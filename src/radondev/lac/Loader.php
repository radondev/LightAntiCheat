<?php

declare(strict_types=1);

namespace radondev\lac;

use pocketmine\plugin\PluginBase;
use radondev\lac\commands\LACCommand;
use radondev\lac\tasks\ExchangeTask;

class Loader extends PluginBase
{
    /**
     * @var Loader
     */
    private static $instance;
    /**
     * @var LightAntiCheat
     */
    private $lightAntiCheat;

    public function onLoad()
    {
        self::$instance = $this;
    }

    public function onEnable()
    {
        $this->lightAntiCheat = new LightAntiCheat(
            $this->getServer()->getLoader(), $this->getServer()->getLogger()
        );

        $this->getServer()->getCommandMap()->registerAll("lightanticheat", [
            new LACCommand($this->getDescription()->getAuthors(), $this->getDescription()->getVersion())
        ]);
        $this->getScheduler()->scheduleRepeatingTask(new ExchangeTask(), 1);
    }

    /**
     * @return Loader
     */
    public static function getInstance(): Loader
    {
        return self::$instance;
    }

    /**
     * @return LightAntiCheat
     */
    public function &getLightAntiCheat(): LightAntiCheat
    {
        return $this->lightAntiCheat;
    }
}