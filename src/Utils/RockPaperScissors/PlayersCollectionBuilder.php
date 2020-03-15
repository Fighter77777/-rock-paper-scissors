<?php

namespace App\Utils\RockPaperScissors;

use App\Exception\InvalidGameConfigException;
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
            $this->validateParameter($param);

            $players[] = new Player($param['name'], $this->playerStrategies[$param['strategy']]);
        }

        return new PlayersCollection($players);
    }

    /**
     * @param $param
     */
    private function validateParameter($param): void
    {
        if (empty($param['name'])) {
            $this->generateError('Empty name', $param);
        }

        if (empty($param['strategy'])) {
            $this->generateError('Empty strategy', $param);
        }

        if (empty($this->playerStrategies[$param['strategy']])) {
            $this->generateError('Strategy not found', $param);
        }
    }

    /**
     * @param $description
     * @param $parametr
     */
    private function generateError($description, $parametr): void
    {
        throw new InvalidGameConfigException(
            sprintf(
                "[PlayersCollectionBuilder] Invalid player's config. %s. Parameters: %s",
                $description,
                json_encode($parametr)
            )
        );
    }
}
