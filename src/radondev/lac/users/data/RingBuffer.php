<?php

declare(strict_types=1);

namespace radondev\lac\users\data;

abstract class RingBuffer
{
    /**
     * @var int
     */
    protected $size;
    /**
     * @var int
     */
    protected $currentPosition;
    /**
     * @var array
     */
    protected $objects;

    /**
     * RingBuffer constructor.
     * @param int $size
     */
    public function __construct(int $size)
    {
        $this->size = $size;
        $this->currentPosition = 0;
        $this->objects = array_fill(0, $size, null);
    }

    /**
     * Returns false, if $object is not an instance of $baseObject
     * @param mixed $object
     */
    protected function add($object): void
    {
        $this->objects[$this->currentPosition] = $object;

        $this->rearrangeCurrentPosition();
    }

    /**
     * @param int $shift
     * @return mixed
     */
    public function get(int $shift = 0)
    {
        $translation = $this->currentPosition + $shift;

        while ($translation < $this->size) {
            $translation += $this->size;
        }

        while ($translation > $this->size) {
            $translation -= $this->size;
        }

        return $this->objects[$translation];
    }

    /**
     * @param int $offset
     * @return mixed
     */
    public function getAt(int $offset)
    {
        if ($offset < 0 || $offset > $this->size) {
            return $this->objects[$offset];
        }

        return null;
    }

    private function rearrangeCurrentPosition(): void
    {
        $this->currentPosition++;

        if ($this->currentPosition >= $this->size) {
            $this->currentPosition = 0;
        }
    }
}