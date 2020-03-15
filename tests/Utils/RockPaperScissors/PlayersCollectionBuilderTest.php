<?php

namespace App\Tests\Util\RockPaperScissors;

use App\Exception\InvalidGameConfigException;
use App\Models\RockPaperScissors\GameElement;
use App\Models\RockPaperScissors\PlayersCollection;
use App\Utils\RockPaperScissors\GameStrategies\AbstractPlayerStrategy;
use App\Utils\RockPaperScissors\GameStrategies\SingleElementStrategy;
use App\Utils\RockPaperScissors\PlayersCollectionBuilder;
use PHPUnit\Framework\TestCase;

/**
 * Class PlayersCollectionBuilderTest
 */
class PlayersCollectionBuilderTest extends TestCase
{
    const STRATEGY_NAME = 'test_strategy';

    const SUCCESSFUL_PLAYER_CONFIG = [
        [
            'name' => 'Player A',
            'strategy' => self::STRATEGY_NAME,
        ],
        [
            'name' => 'Player B',
            'strategy' => self::STRATEGY_NAME,
        ],
    ];

    /**
     * @dataProvider validPlayersConfig
     *
     * @param array $playersConfig
     * @param int   $expectedQuantityPlayers
     */
    public function testSuccessfulBuildPlayersCollection(array $playersConfig, int $expectedQuantityPlayers)
    {
        $playersCollectionBuilder = new PlayersCollectionBuilder();
        $playersCollectionBuilder->addPlayerStrategy(self::STRATEGY_NAME, $this->createStrategy());

        $playersCollection = $playersCollectionBuilder->build($playersConfig);

        $this->assertInstanceOf(PlayersCollection::class, $playersCollection);

        $this->assertEquals($expectedQuantityPlayers, $playersCollection->getQuantityPlayers());
    }

    /**
     * @dataProvider invalidPlayersConfig
     *
     * @param array $playersConfig
     */
    public function testFailBuildPlayersCollection(array $playersConfig)
    {
        $playersCollectionBuilder = new PlayersCollectionBuilder();
        $playersCollectionBuilder->addPlayerStrategy(self::STRATEGY_NAME, $this->createStrategy());

        $this->expectException(InvalidGameConfigException::class);

        $playersCollectionBuilder->build($playersConfig);
    }

    /**
     * @return array
     */
    public function validPlayersConfig()
    {
        return [
            [self::SUCCESSFUL_PLAYER_CONFIG, count(self::SUCCESSFUL_PLAYER_CONFIG)],
            [
                array_merge(self::SUCCESSFUL_PLAYER_CONFIG, self::SUCCESSFUL_PLAYER_CONFIG),
                count(self::SUCCESSFUL_PLAYER_CONFIG) * 2,
            ],
            [[], 0],
            [[self::SUCCESSFUL_PLAYER_CONFIG[0]], 1],
        ];
    }

    /**
     * @return array
     */
    public function invalidPlayersConfig()
    {
        return [
            [['name' => 'Player A', 'strategy' => 'bad']],
            [['name' => 'Player A']],
            [['strategy' => self::STRATEGY_NAME]],
        ];
    }

    /**
     * @return AbstractPlayerStrategy
     */
    private function createStrategy(): AbstractPlayerStrategy
    {
        $gameElement = new GameElement('test element', ['beat all']);

        $strategy = new SingleElementStrategy();
        $strategy->addGameElement($gameElement);

        return $strategy;
    }
}
