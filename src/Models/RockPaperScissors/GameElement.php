<?php

namespace App\Models\RockPaperScissors;

/**
 * Class GameElement
 */
class GameElement
{
    /**
     * @var string
     */
    protected $name;
    /**
     * @var array
     */
    protected $beat = [];

    /**
     * @param string $name
     * @param array  $beat
     */
    public function __construct(string $name, array $beat)
    {
        $this->name = $name;

        foreach ($beat as $weaker) {
            $this->beat[$weaker] = true;
        }
    }

    /**
     * @param GameElement $gameElement
     *
     * @return bool
     */
    public function isStrongerThan(GameElement $gameElement): bool
    {
        return array_key_exists($gameElement->getName(), $this->beat);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }
}
