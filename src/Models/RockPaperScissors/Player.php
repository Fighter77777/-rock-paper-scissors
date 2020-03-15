<?php

namespace App\Models\RockPaperScissors;

use App\Utils\RockPaperScissors\GameStrategies\AbstractPlayerStrategy;

/**
 * Class Player
 */
class Player
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var AbstractPlayerStrategy
     */
    private $strategy;

    /**
     * @param string                 $name
     * @param AbstractPlayerStrategy $strategy
     */
    public function __construct(string $name, AbstractPlayerStrategy $strategy)
    {
        $this->name = $name;
        $this->strategy = $strategy;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return AbstractPlayerStrategy
     */
    public function getStrategy(): AbstractPlayerStrategy
    {
        return $this->strategy;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }
}
