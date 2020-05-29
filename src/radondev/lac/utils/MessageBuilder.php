<?php

declare(strict_types=1);

namespace radondev\lac\utils;

use pocketmine\utils\TextFormat;

final class MessageBuilder
{
    public const PREFIX = TextFormat::YELLOW . "LAC" . TextFormat::RESET;

    /**
     * @param string $message
     * @param array $arguments
     * @return string
     */
    public static function debug(string $message, array $arguments = []): string
    {
        return self::createMessage(TextFormat::GRAY, "DEBUG", $message, TextFormat::DARK_GRAY, $arguments);
    }

    /**
     * @param string $message
     * @param array $arguments
     * @return string
     */
    public static function info(string $message, array $arguments = []): string
    {
        return self::createMessage(TextFormat::WHITE, "", $message, TextFormat::YELLOW, $arguments);
    }

    /**
     * @param string $message
     * @param array $arguments
     * @return string
     */
    public static function success(string $message, array $arguments = []): string
    {
        return self::createMessage(TextFormat::GREEN, "SUCCESS", $message, TextFormat::DARK_GREEN, $arguments);
    }

    /**
     * @param string $message
     * @param array $arguments
     * @return string
     */
    public static function error(string $message, array $arguments = []): string
    {
        return self::createMessage(TextFormat::RED, "ERROR", $message, TextFormat::DARK_RED, $arguments);
    }

    /**
     * @param string $textColor
     * @param string $level
     * @param string $message
     * @param string $highlightColor
     * @param array $arguments
     * @return string
     */
    private static function createMessage(string $textColor, string $level, string $message, string $highlightColor, array $arguments = []): string
    {
        $arguments = self::highlightArguments($highlightColor, $textColor, $arguments);
        $message = sprintf($message, ...$arguments);

        if ($level == "") {
            return self::PREFIX . " > $textColor$message";
        }
        return self::PREFIX . " > $textColor$level: $message";
    }

    /**
     * @param string $highlightColor
     * @param string $previousColor
     * @param array $arguments
     * @return array
     */
    private static function highlightArguments(string $highlightColor, string $previousColor, array $arguments): array
    {
        foreach ($arguments as $position => $argument) {
            $arguments[$position] = $highlightColor . $argument . $previousColor;
        }

        return $arguments;
    }
}