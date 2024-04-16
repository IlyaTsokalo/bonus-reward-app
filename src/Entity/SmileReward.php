<?php

namespace App\Entity;

class SmileReward implements RewardInterface
{
    public const REWARD_ID = 1;

    public function getId(): int
    {
        return self::REWARD_ID;
    }
}
