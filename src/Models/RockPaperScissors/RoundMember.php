<?php

namespace App\Models\RockPaperScissors;

/**
 * Class RoundMember
 */
class RoundMember
{
    /**
     * @var Player
     */
    private $player;

    /**
     * @var GameElement
     */
    private $gameElement;

    /**
     * @var int
     */
    private $score;

    /**
     * @param Player      $player
     * @param GameElement $gameElement
     * @param int         $score
     */
    public function __construct(Player $player, GameElement $gameElement, int $score)
    {
        $this->player = $player;
        $this->gameElement = $gameElement;
        $this->score = $score;
    }

    /**
     * @return Player
     */
    public function getPlayer(): Player
    {
        return $this->player;
    }

    /**
     * @return GameElement
     */
    public function getGameElement(): GameElement
    {
        return $this->gameElement;
    }

    /**
     * @return int
     */
    public function getScore(): int
    {
        return $this->score;
    }
}
