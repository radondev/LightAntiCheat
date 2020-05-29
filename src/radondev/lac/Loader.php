<?php

declare(strict_types=1);

namespace radondev\lac;

use pocketmine\plugin\PluginBase;
use radondev\lac\commands\LACCommand;

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
    public function getLightAntiCheat(): LightAntiCheat
    {
        return $this->lightAntiCheat;
    }
}