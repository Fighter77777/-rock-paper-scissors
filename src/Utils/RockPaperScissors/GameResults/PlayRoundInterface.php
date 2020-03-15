<?php

namespace App\Utils\RockPaperScissors\GameResults;

use App\Models\RockPaperScissors\PlayersCollection;
use App\Models\RockPaperScissors\Round;

/**
 * Interface PlayRoundInterface
 */
interface PlayRoundInterface
{
    /**
     * @param PlayersCollection $playersCollection
     *
     * @return Round
     */
    public function play(PlayersCollection $playersCollection): Round;
}
