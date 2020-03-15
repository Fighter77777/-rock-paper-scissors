<?php

namespace App\Models\RockPaperScissors;

/**
 * Class GameSeries
 */
class GameSeries
{
    /**
     * @var
     */
    private $rounds;

    /**
     * @param $rounds
     */
    public function __construct($rounds)
    {
        $this->rounds = $rounds;
    }

    /**
     * @return mixed
     */
    public function getRounds()
    {
        return $this->rounds;
    }
}
