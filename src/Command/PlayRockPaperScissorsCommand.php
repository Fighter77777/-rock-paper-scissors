<?php

namespace App\Command;

use App\OutputFormatters\GameResultOutput;
use App\Utils\RockPaperScissors\GameLauncher;
use App\Utils\RockPaperScissors\PlayersCollectionBuilder;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidOptionException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class PlayRockPaperScissorsCommand
 */
class PlayRockPaperScissorsCommand extends Command
{
    private const GAME_TITLE = 'ROCK, PAPER, SCISSORS';

    private const OPTION_ROUND_TIMES = 'rounds';
    private const DEFAULT_ROUND_TIMES = 100;

    /**
     * @var GameLauncher
     */
    private $gameLauncher;

    /**
     * @var PlayersCollectionBuilder
     */
    private $playersCollectionBuilder;

    /**
     * @var GameResultOutput
     */
    private $gameResultOutput;

    /**
     * @var array
     */
    private $playersParams;

    /**
     * @param GameLauncher             $gameLauncher
     * @param PlayersCollectionBuilder $playersCollectionBuilder
     * @param GameResultOutput         $gameResultOutput ,
     * @param array                    $playersParams
     */
    public function __construct(
        GameLauncher $gameLauncher,
        PlayersCollectionBuilder $playersCollectionBuilder,
        GameResultOutput $gameResultOutput,
        array $playersParams
    ) {
        $this->gameLauncher = $gameLauncher;
        $this->playersCollectionBuilder = $playersCollectionBuilder;
        $this->gameResultOutput = $gameResultOutput;
        $this->playersParams = $playersParams;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('app:play:rock-paper-scissors')
            ->setAliases(['play'])
            ->setDescription('To play rock, paper, scissors run the command bin/console play')
            ->addOption(
                self::OPTION_ROUND_TIMES,
                'r',
                InputOption::VALUE_OPTIONAL,
                'Set quantity of rounds',
                self::DEFAULT_ROUND_TIMES
            );
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $times = $this->getTimes($input);

        $players = $this->playersCollectionBuilder->build($this->playersParams);
        $gameSeries = $this->gameLauncher->play($players, $times);

        $this->gameResultOutput->renderResults($output, $players, $gameSeries, self::GAME_TITLE);

        return OutputInterface::OUTPUT_NORMAL;

    }

    private function getTimes(InputInterface $input): int
    {
        $times = $input->getOption(self::OPTION_ROUND_TIMES);
        if (!is_numeric($times)) {
            throw new InvalidOptionException('Rounds times should be integer');
        }

        return (int) $times;
    }
}
