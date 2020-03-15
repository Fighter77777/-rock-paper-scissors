<?php

namespace App\Command;

use App\Exception\InvalidGameConfigException;
use App\OutputFormatters\GameResultOutput;
use App\Utils\RockPaperScissors\GameLauncher;
use App\Utils\RockPaperScissors\PlayersCollectionBuilder;
use Psr\Log\LoggerInterface;
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

    private const EXIT_CODE_SUCCESSFUL = 100;
    private const EXIT_CODE_INVALID_GAME_CONFIG = 2;

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
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var array
     */
    private $playersParams;

    /**
     * @param GameLauncher             $gameLauncher
     * @param PlayersCollectionBuilder $playersCollectionBuilder
     * @param GameResultOutput         $gameResultOutput ,
     * @param LoggerInterface          $logger
     * @param array                    $playersParams
     */
    public function __construct(
        GameLauncher $gameLauncher,
        PlayersCollectionBuilder $playersCollectionBuilder,
        GameResultOutput $gameResultOutput,
        LoggerInterface $logger,
        array $playersParams
    ) {
        $this->gameLauncher = $gameLauncher;
        $this->playersCollectionBuilder = $playersCollectionBuilder;
        $this->gameResultOutput = $gameResultOutput;
        $this->logger = $logger;
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

        try {
            $players = $this->playersCollectionBuilder->build($this->playersParams);
            $gameSeries = $this->gameLauncher->play($players, $times);
        } catch (InvalidGameConfigException $exception) {
            $this->handleError($exception, $output);

            return self::EXIT_CODE_INVALID_GAME_CONFIG;
        }

        $this->gameResultOutput->renderResults($output, $players, $gameSeries, self::GAME_TITLE);

        return self::EXIT_CODE_SUCCESSFUL;

    }

    /**
     * @param InputInterface $input
     *
     * @return int
     */
    private function getTimes(InputInterface $input): int
    {
        $times = $input->getOption(self::OPTION_ROUND_TIMES);
        if (!is_numeric($times) || $times <= 1) {
            throw new InvalidOptionException('Rounds times should be integer and greater then 0');
        }

        return (int) $times;
    }

    /**
     * @param InvalidGameConfigException $exception
     * @param OutputInterface            $output
     */
    private function handleError(InvalidGameConfigException $exception, OutputInterface $output): void
    {
        $output->writeln("<error>Invalid game's config</error>");

        $this->logger->error(
            $exception->getMessage(),
            ['file' => $exception->getFile(), 'line' => $exception->getLine()]
        );
    }
}
