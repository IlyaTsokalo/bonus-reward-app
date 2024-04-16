<?php

namespace App\Entity;

class HugReward implements RewardInterface
{
    public const REWARD_ID = 2;

    public function getId(): int
    {
        return self::REWARD_ID;
    }
}
