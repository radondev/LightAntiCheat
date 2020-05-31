<?php

declare(strict_types=1);

namespace radondev\lac\threading\player;

use radondev\lac\threading\Info;
use radondev\lac\threading\PlayerExchangePacket;

class PlayerChatEventPacket extends PlayerExchangePacket
{
    /**
     * @var string $message
     */
    private $message;

    /**
     * PlayerChatEventPacket constructor.
     * @param string $rawUuid
     * @param string $message
     */
    public function __construct(string $rawUuid, string $message)
    {
        $this->message = $message;

        parent::__construct(Info::PLAYER_CHAT_EVENT_PACKET, $rawUuid);
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }
}