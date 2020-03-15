<?php

namespace App\Utils\RockPaperScissors\GameStrategies;

use App\Models\RockPaperScissors\GameElement;

/**
 * Class PlayerStrategyFactory
 */
class PlayerStrategyFactory
{
    /**
     * @var GameElement[]
     */
    private $gameElements = [];

    /**
     * PlayerStrategyFactory constructor.
     *
     * @param array $elementsNames
     * @param array $elementsBeat
     */
    public function __construct(array $elementsNames, array $elementsBeat)
    {
        $this->createGameElements($elementsNames, $elementsBeat);
    }

    /**
     * @param string $class
     * @param array  $elementsNames
     *
     * @return AbstractPlayerStrategy
     */
    public function createPlayerStrategy(string $class, array $elementsNames): AbstractPlayerStrategy
    {
        $playerStrategy = new $class();
        /**@var AbstractPlayerStrategy $playerStrategy * */

        foreach ($elementsNames as $elementName) {
            if (array_key_exists($elementName, $this->gameElements)) {
                $playerStrategy->addGameElement($this->gameElements[$elementName]);
            }
        }

        return $playerStrategy;
    }

    /**
     * @param array $elementsNames
     * @param array $elementsBeat
     */
    private function createGameElements(array $elementsNames, array $elementsBeat): void
    {
        foreach ($elementsNames as $name) {
            $beats = $elementsBeat[$name] ?? [];
            $this->gameElements[$name] = new GameElement($name, $beats);
        }
    }
}
