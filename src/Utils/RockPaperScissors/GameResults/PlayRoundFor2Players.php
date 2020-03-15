<?php

namespace App\Utils\RockPaperScissors\GameResults;

use App\Models\RockPaperScissors\GameElement;
use App\Models\RockPaperScissors\PlayersCollection;
use App\Models\RockPaperScissors\Round;
use App\Models\RockPaperScissors\RoundMember;

/**
 * Class PlayRoundFor2Players
 */
class PlayRoundFor2Players implements PlayRoundInterface
{
    /**
     * @param PlayersCollection $playersCollection
     *
     * @return Round
     */
    public function play(PlayersCollection $playersCollection): Round
    {
        $players = $gameElements = $score = [];
        foreach ($playersCollection as $player) {
            $players[] = $player;
            $gameElements[] = $player->getStrategy()->selectGameElement();
        }

        $score[0] = ($this->firstElementBeatsSecond($gameElements[0], $gameElements[1])) ? 1 : 0;
        $score[1] = ($this->firstElementBeatsSecond($gameElements[1], $gameElements[0])) ? 1 : 0;

        $rounds = [
            new RoundMember($players[0], $gameElements[0], $score[0]),
            new RoundMember($players[1], $gameElements[1], $score[1]),
        ];

        return Round::createRound($rounds);
    }

    /**
     * @param GameElement $player1Element
     * @param GameElement $player2Element
     *
     * @return bool
     */
    protected function firstElementBeatsSecond(GameElement $player1Element, GameElement $player2Element): bool
    {
        return $player1Element->isStrongerThan($player2Element);
    }
}
