<?php

namespace App\Utils\RockPaperScissors\GameStrategies;

use App\Models\RockPaperScissors\GameElement;

/**
 * Class RandomStrategy
 */
class RandomStrategy extends AbstractPlayerStrategy
{
    /**
     * @return GameElement
     */
    public function selectGameElement(): GameElement
    {
        return $this->gamingElements[array_rand($this->gamingElements)];
    }
}
