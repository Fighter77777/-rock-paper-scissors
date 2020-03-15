<?php

namespace App\Models\RockPaperScissors;

use Iterator;

/**
 * Class Players
 */
class PlayersCollection implements Iterator
{
    /**
     * @var Player[]
     */
    private $players = [];

    /**
     * @var int
     */
    private $position = 0;


    /**
     * @param array $players
     */
    public function __construct(array $players)
    {
        $this->players = $players;
        $this->position = 0;
    }

    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * @return Player
     */
    public function current()
    {
        return $this->players[$this->position];
    }

    /**
     * @return int
     */
    public function key()
    {
        return $this->position;
    }

    public function next()
    {
        ++$this->position;
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return isset($this->players[$this->position]);
    }

    /**
     * @return int
     */
    public function getQuantityPlayers(): int
    {
        return count($this->players);
    }
}
