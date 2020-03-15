<?php

namespace App\Utils\RockPaperScissors\GameStrategies;

use App\Models\RockPaperScissors\GameElement;

/**
 * Class SingleElementStrategy
 */
class SingleElementStrategy extends AbstractPlayerStrategy
{
    /**
     * @return GameElement
     */
    public function selectGameElement(): GameElement
    {
        return current($this->gamingElements);
    }
}
