<?php

namespace App\Models\RockPaperScissors;

/**
 * Class Round
 */
class Round
{
    /**
     * @var RoundMember[]
     */
    private $members = [];

    /**
     * @param array $members
     */
    private function __construct(array $members)
    {
        $this->members = $members;
    }

    /**
     * @return RoundMember[]
     */
    public function getMembers(): array
    {
        return $this->members;
    }

    /**
     * @param array $members
     *
     * @return Round
     */
    public static function createRound(array $members) {
        foreach ($members as $member) {
            if (!$member instanceof RoundMember) {
                throw new \InvalidArgumentException('All members of a round should be instance of RoundMember');
            }
        }

        return new self($members);
    }
}
