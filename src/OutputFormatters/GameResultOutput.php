<?php

namespace App\OutputFormatters;

use App\Models\RockPaperScissors\GameSeries;
use App\Models\RockPaperScissors\PlayersCollection;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Interface GameResultOutput
 */
interface GameResultOutput
{
    /**
     * @param OutputInterface   $output
     * @param PlayersCollection $playersCollection
     * @param GameSeries        $gameSeries
     * @param string            $title
     */
    public function renderResults(
        OutputInterface $output,
        PlayersCollection $playersCollection,
        GameSeries $gameSeries,
        string $title
    ): void;
}
