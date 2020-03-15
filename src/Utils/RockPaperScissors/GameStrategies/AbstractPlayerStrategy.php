<?php

namespace App\Utils\RockPaperScissors\GameStrategies;

use App\Models\RockPaperScissors\GameElement;

/**
 * Class AbstractPlayerStrategy
 */
abstract class AbstractPlayerStrategy
{
    /**
     * @var array
     */
    protected $gamingElements = [];

    /**
     * @return GameElement
     */
    abstract public function selectGameElement(): GameElement;

    /**
     * @param GameElement $gameElement
     */
    public function addGameElement(GameElement $gameElement): void
    {
        $this->gamingElements[] = $gameElement;
    }
}
