<?php

namespace App\Tests\Util\RockPaperScissors;

use App\Kernel;
use App\Models\RockPaperScissors\GameElement;
use App\Models\RockPaperScissors\Player;
use App\Models\RockPaperScissors\Round;
use App\Models\RockPaperScissors\RoundMember;
use App\Utils\RockPaperScissors\GameLauncher;
use App\Utils\RockPaperScissors\PlayersCollectionBuilder;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class GameLauncherTest
 */
class GameLauncherTest extends TestCase
{
    const CONTAINER_PLAYERS_PARAMETERS = 'app.game.rock_paper_scissors.players';

    /**
     * @var ContainerInterface
     */
    protected $container;

    public function setUp()
    {
        parent::setUp();

        $kernel = new Kernel('test', true);
        $kernel->boot();
        $container = $kernel->getContainer();
        $this->container = $container->get('test.service_container');
    }

    /**
     *
     */
    public function testSuccessfulPlay()
    {
        $this->assertTrue($this->container->hasParameter(self::CONTAINER_PLAYERS_PARAMETERS));
        $this->assertTrue($this->container->has(PlayersCollectionBuilder::class));
        $this->assertTrue($this->container->has(GameLauncher::class));

        $playersParam = $this->container->getParameter(self::CONTAINER_PLAYERS_PARAMETERS);
        $playersCollectionBuilder = $this->container->get(PlayersCollectionBuilder::class);
        $gameLauncher = $this->container->get(GameLauncher::class);

        $roundQuantity = 2;
        $playersCollection = $playersCollectionBuilder->build($playersParam);
        $gameSeries = $gameLauncher->play($playersCollection, $roundQuantity);

        $roundsInSeries = 0;
        foreach ($gameSeries->getRounds() as $round) {
            ++$roundsInSeries;

            $this->assertInstanceOf(Round::class, $round);

            foreach ($round->getMembers() as $member) {
                /**@var RoundMember $member * */
                $this->assertInstanceOf(RoundMember::class, $member);
                $this->assertInstanceOf(Player::class, $member->getPlayer());
                $this->assertInstanceOf(GameElement::class, $member->getGameElement());
                $this->assertIsInt($member->getScore());
            }
        }

        $this->assertEquals($roundQuantity, $roundsInSeries);
    }
}
