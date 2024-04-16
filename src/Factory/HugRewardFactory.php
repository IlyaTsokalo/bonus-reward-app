<?php

namespace App\Factory;

use App\Entity\HugReward;
use App\Entity\RewardInterface;

class HugRewardFactory implements RewardFactoryInterface
{
    public function createReward(): RewardInterface
    {
        return new HugReward();
    }
}
