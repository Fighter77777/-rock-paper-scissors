<?php

namespace App\Utils\RockPaperScissors;

use App\Models\RockPaperScissors\Player;
use App\Models\RockPaperScissors\PlayersCollection;
use App\Utils\RockPaperScissors\GameStrategies\AbstractPlayerStrategy;

/**
 * Class PlayersCollectionBuilder
 */
class PlayersCollectionBuilder
{
    /**
     * @var AbstractPlayerStrategy[]
     */
    private $playerStrategies = [];

    /**
     * @param string                 $strategyName
     * @param AbstractPlayerStrategy $playerStrategy
     */
    public function addPlayerStrategy(string $strategyName, AbstractPlayerStrategy $playerStrategy): void
    {
        $this->playerStrategies[$strategyName] = $playerStrategy;
    }

    /**
     * @param array $playersParams
     *
     * @return PlayersCollection
     */
    public function build(array $playersParams): PlayersCollection
    {
        $players = [];
        foreach ($playersParams as $param) {
            $name = $param['name'] ?? '';//todo error
            if (empty($this->playerStrategies[$param['strategy']])) {
                //todo error
            }
            $players[] = new Player($name, $this->playerStrategies[$param['strategy']]);
        }

        return new PlayersCollection($players);
    }
}
