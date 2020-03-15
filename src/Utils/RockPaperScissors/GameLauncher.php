<?php

namespace App\Utils\RockPaperScissors;

use App\Models\RockPaperScissors\GameSeries;
use App\Models\RockPaperScissors\PlayersCollection;
use App\Utils\RockPaperScissors\GameResults\PlayRoundInterface;
use \Iterator;

/**
 * Class GameLauncher
 */
class GameLauncher
{
    /**
     * @var PlayRoundInterface
     */
    private $playRoundService;

    /**
     * @param PlayRoundInterface $playRoundService
     */
    public function __construct(PlayRoundInterface $playRoundService)
    {
        $this->playRoundService = $playRoundService;
    }

    /**
     * @param PlayersCollection $playersCollection
     * @param int               $times
     *
     * @return GameSeries
     */
    public function play(PlayersCollection $playersCollection, int $times): GameSeries
    {
        $rounds = $this->processRounds($playersCollection, $times);

        return new GameSeries($rounds);
    }

    /**
     * @param PlayersCollection $playersCollection
     * @param int               $times
     *
     * @return Iterator
     */
    private function processRounds(PlayersCollection $playersCollection, int $times): Iterator
    {
        for ($i = 0; $i < $times; $i++) {
            yield $this->playRoundService->play($playersCollection);
        }

        /*$rounds = [];

        for ($i = 0; $i < $times; $i++) {
            $rounds[] = $this->playRoundService->play($playersCollection);
        }

        return $rounds;*/
    }
}
