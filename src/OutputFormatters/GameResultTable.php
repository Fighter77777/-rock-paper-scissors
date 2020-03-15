<?php

namespace App\OutputFormatters;

use App\Models\RockPaperScissors\GameSeries;
use App\Models\RockPaperScissors\PlayersCollection;
use App\Models\RockPaperScissors\Round;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class GameResultTable
 * @package App\Utils\RockPaperScissors\OutputFormatters
 */
class GameResultTable implements GameResultOutput
{
    const PLAYER_HEADER = ['Player name', 'Game element', 'Score'];

    /**
     * @var Table
     */
    private $table;

    /**
     * @var array
     */
    private $total = [];

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
    ): void {
        $this->table = new Table($output);
        $this->generateHeader($playersCollection, $title);
        $this->generateBody($gameSeries);
        $this->table->render();

        $this->generateTotal($output);
    }

    /**
     * @param PlayersCollection $playersCollection
     * @param string            $title
     */
    private function generateHeader(PlayersCollection $playersCollection, string $title): void
    {
        $quantityPlayers = $playersCollection->getQuantityPlayers();
        $header = [];
        for ($i = 0; $i < $quantityPlayers; $i++) {
            $header = array_merge($header, self::PLAYER_HEADER);
        }

        $this->table->setHeaderTitle($title)->setHeaders($header);
    }

    /**
     * @param GameSeries $gameSeries
     */
    private function generateBody(GameSeries $gameSeries): void
    {
        foreach ($gameSeries->getRounds() as $round) {
            /**@var Round $round * */
            $row = [];
            foreach ($round->getMembers() as $member) {
                $playerName = (string) $member->getPlayer();
                $row = array_merge($row, [$playerName, $member->getGameElement(), $member->getScore()]);

                if (empty($this->total[$playerName])) {
                    $this->total[$playerName] = 0;
                }
                $this->total[$playerName] += $member->getScore();
            }

            $this->table->addRow($row);
        }
    }

    private function generateTotal(OutputInterface $output): void
    {
        $maxScore = max($this->total);

        $output->writeln('<comment>TOTAL</comment>');
        foreach ($this->total as $playerName => $playerScore) {
            $fontColor = $playerScore === $maxScore ? 'green' : 'red';
            $output->writeln(sprintf('<fg=%s>%s - score: %d</>', $fontColor, $playerName, $playerScore));
        }
    }
}
