<?php

namespace radondev\lac\users;

class User
{
    // TODO Add fields if required
    /**
     * @var string $rawUuid
     */
    private $rawUuid;

    /**
     * User constructor.
     * @param string $rawUuid
     */
    public function __construct(string $rawUuid)
    {
        $this->rawUuid = $rawUuid;
    }

    /**
     * @return string
     */
    public function getRawUuid(): string
    {
        return $this->rawUuid;
    }
}