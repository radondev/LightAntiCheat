<?php

declare(strict_types=1);

namespace radondev\lac\users;

class UserManager
{
    /**
     * @var User[]
     */
    private $users;

    /**
     * UserManager constructor.
     */
    public function __construct()
    {
        $this->users = [];
    }

    /**
     * Returns false if the uuid is already taken
     *
     * @param User $user
     * @return bool
     */
    public function registerUser(User $user): bool
    {
        $uuid = $user->getRawUuid();

        if (!isset($this->users[$uuid])) {
            $this->users[] = $user;

            return true;
        }

        return false;
    }

    /**
     * @param string $rawUuid
     */
    public function unregisterUser(string $rawUuid): void
    {
        if (isset($this->users[$rawUuid])) {
            unset($this->users[$rawUuid]);
        }
    }

    /**
     * @param string $rawUuid
     * @return User|null
     */
    public function getUser(string $rawUuid): ?User
    {
        if (isset($this->users[$rawUuid])) {
            return $this->users[$rawUuid];
        }

        return null;
    }

    /**
     * @return User[]
     */
    public function getUsers(): array
    {
        return $this->users;
    }
}